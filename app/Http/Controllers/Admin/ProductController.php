<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        return view('admin.products.index',compact('products','categories'));
    }

    public function create()
    {
        $categories = Category::orderByDesc('id')->get();
        return view('admin.products.create',compact('categories'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        // Store Images
        foreach($data['images'] as $img){ 
            $path = $img->store('products','public');
            ProductImages::create([
                'product_id' => $product->id,
                'image' => $path,
                'is_primary' => false
            ]);
        }
        // Make an image primary
        ProductImages::where('product_id',$product->id)->first()->update(['is_primary' => true]);

        return to_route('admin.products.index')->with('success','Le produit a été créé avec succès.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderByDesc('created_at')->get();
        return view('admin.products.edit',compact('product','categories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if(isset($data['images'])){
            foreach($data['images'] as $img){ 
                $path = $img->store('products','public');
                ProductImages::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_primary' => false
                ]);
            }
        }
        $product->update($data);
        return to_route('admin.products.index')->with('success','Le produit a été modifiée avec succès.');
    }

    public function toggle(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();
        $status = $product->is_active ? 'activé' : 'désactivé';
        return back()->with('success',"Le produit a été $status avec succès.");
    }

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->delete();
        return to_route('admin.products.index')->with("success","Le produit a été supprimée avec succès.");
    }
}
