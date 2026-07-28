<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::when(request('search'), fn ($q, $sr) => $q->where("title","LIKE","%". $sr ."%")->orwhere("description","LIKE","%". $sr ."%"))
            
            ->when( request('category') , fn($q) => $q->whereHas('category', fn ($q) => $q->where('slug', request('category') ) ) )

            ->when(!is_null(request('is_active')) && in_array(request('is_active'),[0,1]), fn ($q) => $q->where('is_active', request('is_active')))

            ->when(request('price_min'), fn($q,$p) => $q->where('selling_price','>=',$p))
            ->when(request('price_max'), fn($q,$p) => $q->where('selling_price','<=',$p))

            ->when(request('stock_min'), fn($q,$s) => $q->where('stock','>=',$s))
            ->when(request('stock_max'), fn($q,$s) => $q->where('stock','<=',$s))
            
            ->orderBy(request('sort','created_at') , request('direction','desc'))
            ->paginate(20)
            ->withQueryString();

        $categories = Category::orderByDesc('id')->get();
        
        return view('products.index',compact('products','categories'));
    }
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }
}
