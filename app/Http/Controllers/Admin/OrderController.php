<?php

namespace App\Http\Controllers\Admin;

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

    public function show(Order $order)
    {
        return view('admin.orders.show',compact('order'));
    }

    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order, SenditService $agency)
    {
        if($order->sendit_code) {
            $agency->delete($order->sendit_code);
        };
        
        $order->customer->delete();
        return back()->with('success','La commande a été supprimée avec succès.');
    }
}
