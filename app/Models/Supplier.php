<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name','slug','phone','note','address','image'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function booted(): void
    {
        static::saving(function ($supplier) {
            if ($supplier->isDirty('name')) {
                $supplier->slug = Str::slug($supplier->name);
            }
        });
    }
}
