<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\SenditDeliveriesService;
use Illuminate\Support\Facades\DB;

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
        $statistiques = [
            'totalRevenue' => Order::where('status','DELIVERED')
                ->sum('total_price'),
            'totalProfit' => OrderItem::query()
                ->selectRaw('sum( quantity * ( selling_price - purchase_price) ) as total_revenue')
                ->first()
                ->total_revenue,
            'monthProfit' => OrderItem::query()
                ->selectRaw('sum( quantity * ( selling_price - purchase_price) ) as total_revenue')
                ->where('created_at','>=',now()->startOfMonth())
                ->first()
                ->total_revenue,
            
            'totalOrders' => Order::count(),
            'totalDayOrders' => Order::where('created_at','>=',now()->startOfDay())->count(),
            'totalMonthOrders' => Order::where('created_at','>=',now()->startOfMonth())->count(),
            'totalYearOrders' => Order::where('created_at','>=',now()->startOfYear())->count(),
            'preparingOrders' =>  Order::where('status','PREPARING')->count(),
            'toPickedOrders' =>  Order::whereIn('status', ['PREPARING','PENDING','TOPICKUP'])->count(),
            'pickedOrders' => Order::where('status','PICKEDUP')->count(),
            'deliveredOrders' => Order::where('status','DELIVERED')->count(),
            'canceledOrders' => Order::where('status','CANCELED')->count(),

            'totalShiping' => Order::where('status','DELIVERED')->sum('shipping_price'),
            'avgBaskets' => Order::where('status','DELIVERED')->avg('total_price'),
            'maxBasket' => Order::where('status','DELIVERED')->max('total_price'),

            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active',true)->count(),
            'outOfStockProducts' => Product::where('stock',0)->count(),
            'soldItems' => Order::query()
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.status', 'DELIVERED')
                ->selectRaw('SUM(order_items.quantity) as sold_items')
                ->value('sold_items'),

            'bestProducts' => Product::withSum('orderItems as sales_times', 'quantity')
                ->orderByDesc('sales_times')
                ->limit(5)
                ->get(['title']),
            'bestCustomers' => Customer::query()
                ->join('orders','customers.id','=','orders.customer_id')
                ->orderByDesc('total_price')
                ->limit(5)
                ->get(),
            'bestCities' => Order::query()
                ->join('customers','customers.id','=','orders.customer_id')
                ->select('customers.city')
                ->selectRaw(' COUNT(orders.id) as total_orders ')
                ->groupBy('customers.city')
                ->orderByDesc('total_orders')
                ->limit(5)
                ->get(),
        ];

        $statistiques['preparingOrdersPercent'] = $this->percent($statistiques['preparingOrders'],$statistiques['totalOrders'] );
        $statistiques['toPickedOrdersPercent'] = $this->percent($statistiques['toPickedOrders'],$statistiques['totalOrders'] );
        $statistiques['pickedOrdersPercent'] = $this->percent($statistiques['pickedOrders'],$statistiques['totalOrders'] );
        $statistiques['deliveredOrdersPercent'] = $this->percent($statistiques['deliveredOrders'],$statistiques['totalOrders'] );
        $statistiques['canceledOrdersPercent'] = $this->percent($statistiques['canceledOrders'],$statistiques['totalOrders'] );
        return view('admin.dashboard', $statistiques);
    }
}