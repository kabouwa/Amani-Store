<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\Return_;

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
            return Http::post(
                url : $this->apiUrl . '/login',
                data : [
                    'public_key' => config('services.sendit.public_key'),
                    'secret_key' => config('services.sendit.private_key'),
                ]
            )->throw()->json('data.token');
        });
    }
    public function all()
    {
        return Cache::remember('sendit_deliveries', now()->addDay(), function (){
            return Http::withToken( $this->getToken() )->get(
                url : $this->apiUrl . '/deliveries'
            )->throw()->json('data');
        });
    }
    public function status(string $code)
    {
        return Cache::remember('sendit_status_' . $code, now()->addMinutes(10), function () use ($code){
            return Http::withToken( $this->getToken() )->get(
                url : $this->apiUrl . '/deliveries/' . $code
            )->throw()->json('data.status');
        });
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
        $data = Http::withToken( $this->getToken() )->post(
            url : $this->apiUrl . '/deliveries',
            data : $package
        )->throw()->json('data');
        Cache::forget('sendit_deliveries');

        $order->update([
            'sendit_code' => $data['code'],
            'status' => null
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