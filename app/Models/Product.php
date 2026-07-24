<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['category_id','title','slug','description','stock','purchase_price','selling_price','is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
       return $this->hasMany(ProductImages::class);
    }
    public function primaryImage()
    {
       return $this->hasOne(ProductImages::class)
            ->where('is_primary',true);
    }

    public function salesCount() : int
    {
        return OrderItem::where('product_id',$this->id)
            ->sum('quantity');
    }

    public function totalSales() : float
    {
        return OrderItem::where('product_id',$this->id)
            ->get()
            ->sum(fn ($item) => $item->quantity * $item->price);
    }

    protected static function booted(): void
    {
        static::saving(function ($product) {
            if ( $product->isDirty('title') ) $product->slug = Str::slug($product->title);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
