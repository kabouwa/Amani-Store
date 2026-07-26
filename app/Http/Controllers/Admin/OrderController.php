<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\SenditService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(SenditService $agency)
    {
        $orders = Order::get()->each(function ($order) use ($agency) {
            if($order->hasShipment()){
                $order->status = $agency->status($order->sendit_code);
            }
        });
        return view('admin.orders.index',compact('orders'));
    }
    public function show(Order $order, SenditService $agency)
    {
        if($order->hasShipment()){
                $order->status = $agency->status($order->sendit_code);
        }
        return view('admin.orders.show',compact('order'));
    }
    public function edit(Order $order, SenditService $agency)
    {
        $this->authorize('update', $order);
        if($order->hasShipment()){
                $order->status = $agency->status($order->sendit_code);
        }
        $cities = $agency->cities();
        return view('admin.orders.edit',compact('order','cities'));
    }
    public function update(Order $order, SenditService $agency, OrderRequest $request)
    {
        $this->authorize('update', $order);
        
        $data = $request->validated();

        $data['city'] = $agency->city($data['district_id']);

        if(!$data['city']) to_route('admin.orders.show', $order->code)->with('error','La ville est invalide.');

        $order->customer->update($data);

        if($order->hasShipment()){
            $agency->delete($order) ;
            $agency->create($order);
        }

        return to_route('admin.orders.show', $order->code)->with('success','La commande a été modifée avec succès.');
    }
    public function destroy(Order $order, SenditService $agency)
    {
        $this->authorize('delete', $order);
        if($order->hasShipment()) {
            $agency->delete($order);
        };
        
        $order->customer->delete();
        return to_route('admin.orders.index')->with('success','La commande a été supprimée avec succès.');
    }
}
