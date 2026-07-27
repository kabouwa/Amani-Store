<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\Return_;

class SenditDeliveriesService extends SenditService
{
    public function __construct()
    {
        parent::__construct();
    }
    public function all()
    {
        return Cache::remember('sendit_deliveries', now()->addMinutes(10), function (){
            $deliveries = [];

            $data = Http::withToken( $this->getToken() )->get(
                url : $this->apiUrl . '/deliveries',
            )->throw()->json();
            $deliveries = $data['data'];
        
            for($i = 2 ; $i <= $data['last_page']; $i++){
                $nextDeliveries = Http::withToken( $this->getToken() )->get(
                    url : $this->apiUrl . '/deliveries?page=' . $i,
                )->throw()->json('data');
                $deliveries = array_merge($deliveries,$nextDeliveries);
            }

            return $deliveries;
        });
    }
    public function updateStatus()
    {
        $deliveries = collect($this->all())->keyBy('reference') ;
        
        Order::whereNotNull('sendit_code')
            ->get()
            ->each(function ($order) use ($deliveries) {
                $delivery = $deliveries->get($order->code);
                if(!$delivery) return;
                if($order->status !== $delivery['status']){
                    $order->update([
                        'status' => $delivery['status']
                    ]);
                }
            });
        // Get one status
        // return Cache::remember('sendit_status_' . $code, now()->addMinutes(10), function () use ($code){
        //     return Http::withToken( $this->getToken() )->get(
        //         url : $this->apiUrl . '/deliveries/' . $code
        //     )->throw()->json('data.status');
        // });
    }
    public function city(int $id)
    {
        $city = Cache::get("sendit_city_$id");
        if($city) return $city;
        $response = Http::withToken( $this->getToken() )->get(
            url : $this->apiUrl . '/districts/' . $id,
        )->throw();
        if($response->successful()){
            $city = $response->json()['data']['name'];
            Cache::put("sendit_city_$id" , $city, now()->addMonth() );
        } 
        return $city;
    }
    public function cities()
    {
        return Cache::remember('sendit_cities', now()->addMonth(), function(){
            $cities = [];
    
            $response = Http::withToken( $this->getToken() )->get(
                url : $this->apiUrl . '/districts?page=1',
            )->throw();
            $data = $response->json();
            $cities = $data['data'];
    
            for($i = 2 ; $i <= $data['last_page']; $i++){
                $response = Http::withToken( $this->getToken() )->get(
                    url : $this->apiUrl . '/districts?page=' . $i,
                )->throw();
                $data = $response->json();
                foreach($data['data'] as $city){
                    $cities[] = $city;
                } ;
            }
            return collect($cities)->sortBy('name')->values()->all();
        });
    }
    public function create(
        Order $order, 
        string $comment = 'Fragile – Merci de manipuler avec le plus grand soin.',
        int $allow_open = 1,
        int $allow_try = 1,
        )
    {
        $package = [
            // Required Value
            "district_id"=> $order->customer->district_id,
            "name"       => $order->customer->name,
            "address"    => $order->customer->address,
            "phone"      => $order->customer->phone,
            "reference"  => $order->code,
            "amount"     => $order->total_price,
            "products"   => '',

            //Default Values
            "comment" => $comment,
            "pickup_district_id" => $this->pickup_district_id,
            "allow_open"=> $allow_open,
            "allow_try"=> $allow_try,
            "packaging_id" => 1,
            "option_exchange" => 0,
            "delivery_exchange_id" => "",
            "products_from_stock"=> 0,
        ];
        $package['products'] =$order->items
            ->map(fn ($item) => "x{$item->quantity} {$item->product->title}")
            ->implode(', ');
        
        // Send Creation Request 
        $data = Http::withToken( $this->getToken() )->post(
            url : $this->apiUrl . '/deliveries',
            data : $package
        )->throw()->json('data');
        Cache::forget('sendit_deliveries');

        $order->update([
            'sendit_code' => $data['code'],
            'status' => $data['status']
        ]);

        return $data;
    }
    public function delete(Order $order)
    {
        $response = Http::withToken( $this->getToken() )->delete(
            url : $this->apiUrl . '/deliveries/' . $order->sendit_code
        )->throw();
        Cache::forget('sendit_deliveries');
        Cache::forget("sendit_status_" . $order->sendit_code);
        $order->update([
            'sendit_code' => null,
            'status' => 'PREPARING'
        ]);
        return $response->json();
    }

    public function getStatusDeliveries()
    {
        $response = Http::withToken( $this->getToken() )->get(
            url : $this->apiUrl . '/all-status-deliveries'
        )->throw();
        return $response->json();
    }
}