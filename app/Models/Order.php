<?php

namespace App\Models;

use App\Services\SenditService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['order_code','customer_id','shipping_price','total_price','shipping_agency','status','sendit_code'];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->HasMany(OrderItem::class);
    }

    public  function hasShipment() : bool
    {
        return is_null($this->status);
    }

    public function getRouteKeyName() : string
    {
        return 'code';
    }

    protected static function booted() : void
    {
        static::deleting(function ($order) {
            $order->items()->delete();
        });
    }
}
