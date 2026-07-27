<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\SenditPickupService;
use Exception;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    public function index(SenditPickupService $pickupService)
    {
        $orders = Order::query()
        ->whereNotNull('sendit_code')
        ->where('is_picked', false)
        ->get();
        $pickups = collect($pickupService->all())
            ->map(fn ($pickup) => (object) $pickup);
        return view('admin.pickups.index',compact('orders','pickups'));
    }

    public function store(Request $request, SenditPickupService $pickupService)
    {
        $data = $request->validate([
            'sendit_codes' => 'required|array|min:1',
            'sendit_codes.*' => 'required|string|min:7|max:20|exists:orders,sendit_code'
        ]);
        $pickupService->create($data['sendit_codes']);
        return back()->with('success','La demande de ramassage a été envoyée avec succès.');
    }

    public function destroy(string $pickup, SenditPickupService $pickupService)
    {
        try{
            $pickupService->delete($pickup);
        }catch(Exception $e){
            return back()->with('error', 'Un erreur est survenue. Le ramassage n\'existe pas.');
        }
        return back()->with('success','La demande de ramassage a été supprimée avec succès.');
    }
}
