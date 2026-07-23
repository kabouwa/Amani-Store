<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id','title','slug','description','stock','purchase_price','selling_price','image','is_active'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
