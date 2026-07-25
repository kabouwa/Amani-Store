<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SenditService
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.sendit.api');

    }
    private function getToken() : string
    {
        return Cache::remember('sendit_token', now()->addMinutes(50), function () {
            $response = Http::post(
                url : $this->apiUrl . '/login',
                data : [
                    'public_key' => config('services.sendit.public_key'),
                    'secret_key' => config('services.sendit.private_key'),
                ]
            )->throw();
            return $response->json()['data']['token'];
        });
    }
    public function all()
    {
        return Cache::remember('sendit_deliveries', now()->addDay(), function (){
            $response = Http::withToken( $this->getToken() )->get(
                url : $this->apiUrl . '/deliveries'
            )->throw();
            return $response->json()['data'];
        });
    }
    public function status(string $code)
    {
        return Cache::remember('sendit_status_' . $code, now()->addMinutes(10), function () use ($code){
            $response = Http::withToken( $this->getToken() )->get(
                url : $this->apiUrl . '/deliveries/' . $code
            )->throw();
            return $response->json()['data']['status'];
        });
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
            return $cities ;
        });
    }
    public function create(
        Order $order, 
        string $comment = 'Fragile – Merci de manipuler avec le plus grand soin.',
        int $allow_open = 1,
        int $allow_try = 1,
        int $pickup_district_id = 190
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
            "pickup_district_id" => $pickup_district_id,
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
        $response = Http::withToken( $this->getToken() )->post(
            url : $this->apiUrl . '/deliveries',
            data : $package
        )->throw();
        Cache::forget('sendit_deliveries');

        return $response->json()['data'];
    }
    public function delete(string $code)
    {
        $response = Http::withToken( $this->getToken() )->delete(
            url : $this->apiUrl . '/deliveries/' . $code
        )->throw();
        Cache::forget('sendit_deliveries');
        Cache::forget("sendit_status_$code");
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