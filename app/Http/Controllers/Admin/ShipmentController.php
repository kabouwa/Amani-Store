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
        $this->authorize('update', $order);
        if($order->sendit_code) return back()->with('error', 'Commande deja envoyée à l\'agence de livraison.');
        
        $agency->create($order);

        return back()->with('success', 'Commande bien envoyée à l\'agence de livraison.');
    }
 
    public function destroy(Order $order, SenditService $agency)
    {
        $this->authorize('delete', $order);
        if(!$order->sendit_code) return back()->with('error', 'Commande n\'exsiste pas en agence de livraison.');
        $agency->delete($order);
        return back()->with('success', 'Commande bien supprimée de l\'agence de livraison.');
    }
}
