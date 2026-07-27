<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentRequest;
use App\Models\Order;
use App\Services\SenditDeliveriesService;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function store(Order $order, SenditDeliveriesService $agency)
    {
        $this->authorize('update', $order);
        if($order->sendit_code) return back()->with('error', 'Commande deja envoyée à l\'agence de livraison.');
        
        $agency->create($order);

        return back()->with('success', 'Commande bien envoyée à l\'agence de livraison.');
    }
 
    public function destroy(Order $order, SenditDeliveriesService $agency)
    {
        $this->authorize('delete', $order);
        if(!$order->hasShipment()) return back()->with('error', 'La commande n\'existe pas dans l\'agence de livraison.');
        $agency->delete($order);
        return back()->with('success', 'Commande bien supprimée de l\'agence de livraison.');
    }
}
