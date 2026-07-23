<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    public function product()
    {
       return $this->belongsTo(Product::class);
    }
}
