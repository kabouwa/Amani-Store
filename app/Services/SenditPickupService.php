<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class SenditPickupService extends SenditService
{

    public function __construct()
    {
       parent::__construct();
    }
    public function all()
    {
        return Cache::remember('sendit_pickups', now()->addMinutes(30), function (){
            $pickups = [];

            $data = Http::withToken( $this->getToken() )->get(
                url : $this->apiUrl . '/pickups',
            )->throw()->json();
            $pickups = $data['data'];
        
            for($i = 2 ; $i <= $data['last_page']; $i++){
                $nextPickups = Http::withToken( $this->getToken() )->get(
                    url : $this->apiUrl . '/pickups?page=' . $i,
                )->throw()->json('data');
                $pickups = array_merge($pickups,$nextPickups);
            }

            return $pickups;
        });
    }
    public function get($code)
    {
        return Http::withToken( $this->getToken() )->get(
            url : $this->apiUrl . '/pickups/' . $code,
        )->throw()->json('data');
    }
    public function deliveries($code)
    {
        return array_keys($this->get($code)['deliveries']);
    }
    public function create($codes)
    {
        $pickup = [
            "district_id" => $this->pickup_district_id,
            "name" => $this->pickup_name,
            "phone" => $this->pickup_phone,
            "address" => $this->pickup_address,
            "note" => '',
            "deliveries" => "",
            "movements" => ""
        ];
        $deliveries = [];
        foreach($codes as $code){
            $order = Order::where('sendit_code',$code)->first();
            $deliveries[] = $order->sendit_code;
            $order->update([
                'is_picked' => true
            ]);
        }
        $pickup['deliveries'] = implode(',',$deliveries);

        $data = Http::withToken( $this->getToken() )->post(
            url : $this->apiUrl . '/pickups',
            data : $pickup 
        )->throw()->json('data');

        Cache::forget('sendit_deliveries');
        Cache::forget('sendit_pickups');
        return $data;
    }

    public function delete($code) : array
    {

        $deliveries_codes = $this->deliveries($code);
        foreach($deliveries_codes as $delivery_code){
            Order::where('sendit_code',$delivery_code)->first()->update([
                'is_picked' => false
            ]);
        }

        Cache::forget('sendit_pickups');

        $data = Http::withToken( $this->getToken() )->delete(
            url : $this->apiUrl . '/pickups/' . $code,
        )->throw()->json();

        return $data;
    }
}