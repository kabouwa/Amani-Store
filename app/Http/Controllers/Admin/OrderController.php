<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\LabelsRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\SenditDeliveriesService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(SenditDeliveriesService $agency)
    {
        $agency->updateStatus();

        $orders = Order::query()
        ->join('customers', 'orders.customer_id', '=', 'customers.id')
        ->select('orders.*')
        ->with('customer')
        ->withSum('items as total_items', 'quantity')
        ->when(
            request('search'), fn ($q,$s) =>
                $q->where(function ($q) use ($s) {
                    $q->where('orders.code','LIKE',"%$s%")
                        ->orWhere('customers.name','LIKE',"%$s%")
                        ->orWhere('customers.phone','LIKE',"%$s%")
                        ->orWhere('customers.city','LIKE',"%$s%")
                        ->orWhere('orders.shipping_price',$s)
                        ->orWhere('orders.total_price',$s);
                })
        )
        ->when( request('price_min'), fn ($q,$p) => $q->where('total_price','>=',$p))
        ->when( request('price_max'), fn ($q,$p) => $q->where('total_price','<=',$p))
        ->when( request('status'), fn ($q,$s) => $q->where('status',$s))
        ->orderBy(request('sort', 'created_at') , request('direction', 'desc'))
        ->paginate(20)
        ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }



    public function create(SenditDeliveriesService $agency) {
        $products = Product::with('category')
            ->with('primaryImage')
            ->with('images')
            ->where('stock', '>' , '0')
            ->where('is_active', true)
            ->get();

        $cities = $agency->cities();
        return view('admin.orders.create',compact('cities', 'products'));
    }

    public function store(OrderRequest $request, SenditDeliveriesService $agency) {
        $data = $request->validated();

        // Getting city information from ahipping agency
        $city = $agency->city($data['district_id']);

        if(empty($city)) return redirect()->back()->withInput()->withErrors(['city' => 'La ville est invalide.']);

        $data['city'] = $city['name'];

        // Customer Creation
        $customer_id = Customer::create($data)->id;

        // Order Creation
        $order = Order::create([
            'customer_id' => $customer_id,
            'shipping_price' => $city['price'] - 20,
            'note' => $data['note'],
        ]);

        // Order items Creation
        $total_price = 0;

        foreach( $data['items'] as $item) {
            $product = Product::where('slug', $item['slug'])->first();

            if (empty($product) || $product->stock < $item['quantity']) continue;

            $total_price += $product->selling_price * $item['quantity'];

            $product->update(['stock' => $product->stock - $item['quantity'] ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'purchase_price' => $product->purchase_price,
                'selling_price' => $product->selling_price,
                'quantity' => $item['quantity'],
            ]);
        }

        if (!$total_price ) { // total price stay in 0 mean no item in order
            $order->delete();
            return redirect()->back()->withInput()->withErrors(['items' => 'Une commande ne peut pas être créée sans au moins un article.']);
        }

        // Order Price
        $total_price += 20; // Customer shipping part
        $order->update(compact('total_price'));

        return to_route('admin.orders.index')->with('success','La commande a été créer avec succès.');
    }

    public function edit(Order $order, SenditDeliveriesService $agency)
    {
        $this->authorize('update', $order);

        $order_items = $order->items()->get()->keyBy('product_id');

        $products = Product::with('primaryImage')
            ->where('is_active', true)
            ->get()
            // Add item quantity to product stock available on edit
            ->map(function ($product) use ($order_items) {
                $item = $order_items->get($product->id);

                if( $item ) $product->stock += $item->quantity;

                return $product;
            });

        $cities = $agency->cities();

        return view('admin.orders.edit',compact('order','products','cities'));
    }

    public function update(Order $order, SenditDeliveriesService $agency, OrderRequest $request)
    {
        $this->authorize('update', $order);

        $data = $request->validated();

        // Getting city information from ahipping agency
        $city = $agency->city($data['district_id']);

        if(empty($city)) return redirect()->back()->withInput()->withErrors(['city' => 'La ville est invalide.']);

        $data['city'] = $city['name'];

        // Update Customer
        $order->customer->update($data);

        // Update Order
        $order->update([
            'shipping_price' => $city['price'] - 20,
            'note' => $data['note']
        ]);

        // Delete Old order Items and restore old quantities
        foreach ($order->items as $item) {
            $item->delete();
        }

        // Order items Recreate and calc
        $total_price = 0;

        foreach( $data['items'] as $item) {
            $product = Product::where('slug', $item['slug'])->first();

            if (empty($product) || $product->stock < $item['quantity']) continue;

            $total_price += $product->selling_price * $item['quantity'];

            $product->update(['stock' => $product->stock - $item['quantity'] ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'purchase_price' => $product->purchase_price,
                'selling_price' => $product->selling_price,
                'quantity' => $item['quantity'],
            ]);
        }

        if (!$total_price) {
            // Delete from agency if the order has shipement
            if($order->hasShipment()) $agency->delete($order);

            $order->delete();
            return redirect()->back()->withInput()->withErrors(['items' => 'Une commande ne peut pas être créée sans au moins un article.']);
        }

        // Order total price
        $total_price += 20; // Customer shipping part
        $order->update(compact('total_price'));

        // Update in agency if the order has shipement
        if($order->hasShipment()){
            $agency->delete($order);
            $agency->create($order);
        }

        return to_route('admin.orders.show', $order->code)->with('success','La commande a été modifée avec succès.');
    }

    public function destroy(Order $order, SenditDeliveriesService $agency)
    {
        $this->authorize('delete', $order);

        if($order->hasShipment()) {
            $agency->delete($order);
        };

        $order->customer->delete();
        return to_route('admin.orders.index')->with('success','La commande a été supprimée avec succès.');
    }

    public function labels(LabelsRequest $request, SenditDeliveriesService $agency)
    {
        $data = $request->validated();

        // Generate labels link from agency
        $labels_link = $agency->labels($data['printFormat'], ...$data['codes']);

        return $labels_link
            ? redirect(to: $labels_link)
            : back()-> with('error', 'Les codes des colis demandés pour les labels sont invalides.');
    }
}
