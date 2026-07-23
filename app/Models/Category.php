<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title','slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function booted()
    {
        static::deleting(function (Category $category) {
            $category->products()->delete();
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
