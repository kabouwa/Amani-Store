<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','phone','instagram','address'];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
    protected static function booted()
    {
        static::deleting(function (Customer $customer) {
            $customer->order()->delete();
        });
    }
}
