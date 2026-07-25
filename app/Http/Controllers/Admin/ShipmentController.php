<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentRequest;
use App\Models\Order;
use App\Services\SenditService;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function store(Order $order, SenditService $agency)
    {
        if($order->sendit_code) return back()->with('error', 'Commande deja envoyée à l\'agence de livraison.');
        $data = $agency->create($order);
        $order->update([
            'sendit_code' => $data['code'],
            'status' => null
        ]);
        return back()->with('success', 'Commande bien envoyée à l\'agence de livraison.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order, SenditService $agency)
    {
        if(!$order->sendit_code) return back()->with('error', 'Commande n\'exsiste pas en agence de livraison.');
        $agency->delete($order->sendit_code);
        $order->update([
            'sendit_code' => null,
            'status' => 'PREPARING'
        ]);
        return back()->with('success', 'Commande bien supprimée de l\'agence de livraison.');
    }
}
