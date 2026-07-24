<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImages extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','image','is_primary'];
    public function product()
    {
       return $this->belongsTo(Product::class);
    }
    protected static function booted() : void
    {
        static::deleting(function ($productImage) {
            $path = $productImage->image;
            if(Storage::disk('public')->exists($path))

            Storage::disk('public')->move(
                from : $path ,
                to : 'products/trash/' . basename($path),
            );
            
        });
    }
}
