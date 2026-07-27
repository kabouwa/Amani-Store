<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class SenditService
{
    protected string $apiUrl;
    protected string $public_key;
    protected string $private_key;
    protected int $pickup_district_id;
    protected string $pickup_name;
    protected string $pickup_phone;
    protected string $pickup_address;
    public function __construct()
    {
        $this->apiUrl = config('services.sendit.api');
        $this->public_key = config('services.sendit.public_key');
        $this->private_key = config('services.sendit.private_key');
        $this->pickup_district_id = config('services.sendit.pickup.district_id');
        $this->pickup_name = config('services.sendit.pickup.name');
        $this->pickup_phone = config('services.sendit.pickup.phone');
        $this->pickup_address = config('services.sendit.pickup.address');

    }
    protected function getToken() : string
    {
        return Cache::remember('sendit_token', now()->addMinutes(50), function () {
            return Http::post(
                url : $this->apiUrl . '/login',
                data : [
                    'public_key' => $this->public_key,
                    'secret_key' => $this->private_key,
                ]
            )->throw()->json('data.token');
        });
    }
}