<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['order_id','product_id','purchase_price','selling_price','quantity'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getProfitAttribute()
    {
        return ($this->selling_price - $this->purchase_price) * $this->quantity;
    }

    public function getTotalAttribute()
    {
        return $this->selling_price * $this->quantity;
    }

    public static function booted(): void
    {
        static::deleting(function ($ordeItem) {
            $ordeItem->product->update([
                'stock' => $ordeItem->product->stock + $ordeItem->quantity
            ]);
        });

        // after a query // clear dashboard
        static::saved(function () {
            Cache::forget('dashboard-statistics');
        });
        static::deleted(function () {
            Cache::forget('dashboard-statistics');
        });
    }
}
