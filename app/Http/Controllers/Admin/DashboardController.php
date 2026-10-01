<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\SenditDeliveriesService;
use DragonCode\Contracts\Cashier\Config\Payments\Map;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{

    private function percent(int $part, int $total) : float
    {
        return $total > 0
            ? round( ($part / $total) * 100 , 2)
            : 0 ;
    }
    public function index(SenditDeliveriesService $agency)
    {
        $agency->updateStatus();

        $statistics = Cache::remember('dashboard-statistics', now()->addDays(2), function () {

            $stats = [
                // Revenue And Profit
                'totalRevenue' => Order::where('status','DELIVERED')
                    ->sum('total_price'),

                'totalProfit' => OrderItem::query()
                    ->selectRaw('sum( quantity * ( selling_price - purchase_price) ) as total_revenue')
                    ->first()
                    ->total_revenue,

                'monthProfit' => OrderItem::query()
                    ->selectRaw('sum( quantity * ( selling_price - purchase_price) ) as total_revenue')
                    ->where('created_at','>=', now()->startOfMonth())
                    ->first()
                    ->total_revenue,

                // Orders
                'totalOrders' => Order::count(),

                'totalDayOrders' => Order::where('created_at', '>=', now()->startOfDay())->count(),

                'totalMonthOrders' => Order::where('created_at','>=',now()->startOfMonth())->count(),

                'totalYearOrders' => Order::where('created_at','>=',now()->startOfYear())->count(),

                // Shipping total price
                'totalShiping' => Order::where('status','DELIVERED')->sum('shipping_price'),

                // Baskets
                'avgBaskets' => Order::where('status','DELIVERED')->avg('total_price'),

                'maxBasket' => Order::where('status','DELIVERED')->max('total_price'),

                // Products
                'totalProducts' => Product::count(),

                'activeProducts' => Product::where('is_active',true)->count(),

                'outOfStockProducts' => Product::where('stock',0)->count(),

                'soldItems' => Order::query()
                    ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                    ->where('orders.status', 'DELIVERED')
                    ->selectRaw('SUM(order_items.quantity) as sold_items')
                    ->value('sold_items'),

                // Top resources
                'bestProducts' => Product::withSum('orderItems as sales_times', 'quantity')
                    ->orderByDesc('sales_times')
                    ->limit(5)
                    ->get(['title'])->toArray(),

                'bestCustomers' => Customer::query()
                    ->join('orders','customers.id','=','orders.customer_id')
                    ->orderByDesc('total_price')
                    ->limit(5)
                    ->get()->toArray(),

                'bestCities' => Order::query()
                    ->join('customers','customers.id','=','orders.customer_id')
                    ->select('customers.city')
                    ->selectRaw(' COUNT(orders.id) as total_orders ')
                    ->groupBy('customers.city')
                    ->orderByDesc('total_orders')
                    ->limit(5)
                    ->get()->toArray(),

                // Orders Status
                'preparingOrders' =>  Order::where('status','PREPARING')->count(),
                'toPickedOrders' =>  Order::whereIn('status', ['PENDING','TOPICKUP'])->count(),
                'pickedOrders' => Order::where('status','PICKEDUP')->count(),
                'deliveredOrders' => Order::where('status','DELIVERED')->count(),
                'canceledOrders' => Order::where('status','CANCELED')->count(),
            ];

            // foreach($orders as $order) {
            //     $key = match ($order->status) {
            //         "PREPARING" => "preparingOrders",
            //         "PENDING", "TOPICKUP" => "toPickedOrders",
            //         "PICKEDUP" => "pickedOrders",
            //         "DELIVERED" => "deliveredOrders",
            //         "CANCELED" => "canceledOrders",
            //     };

            //     $statistics[$key]++;
            // }

            $stats['preparingOrdersPercent'] = $this->percent( $stats['preparingOrders'],   $stats['totalOrders'] );
            $stats['toPickedOrdersPercent']  = $this->percent( $stats['toPickedOrders'],    $stats['totalOrders'] );
            $stats['pickedOrdersPercent']    = $this->percent( $stats['pickedOrders'],      $stats['totalOrders'] );
            $stats['deliveredOrdersPercent'] = $this->percent( $stats['deliveredOrders'],   $stats['totalOrders'] );
            $stats['canceledOrdersPercent']  = $this->percent( $stats['canceledOrders'] ,   $stats['totalOrders'] );

            return $stats;
        });

        return view('admin.dashboard', $statistics);
    }
}
