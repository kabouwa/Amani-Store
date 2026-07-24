<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;
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
