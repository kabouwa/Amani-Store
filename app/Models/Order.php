<?php

namespace App\Models;

use App\Services\SenditDeliveriesService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['order_code','customer_id','shipping_price','total_price','shipping_agency', 'note', 'status','is_picked','sendit_code'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->HasMany(OrderItem::class);
    }

    // public function getTotalItemsAttribute()
    // {
    //     return $this->items()->sum('quantity');
    // }

    public  function hasShipment() : bool
    {
        return ! is_null($this->sendit_code);
    }

    public function getRouteKeyName() : string
    {
        return 'code';
    }

    protected static function booted() : void
    {
        static::creating(function ($order) {
            do{
                $order->code = 'AMN-' . now()->format('ym') . '-' . random_int(100000, 999999);
            }while(static::where('code',$order->code)->exists());
        });

        static::deleting(function ($order) {
            $order->customer()->delete();
            $order->items()->delete();
        });
    }
}
