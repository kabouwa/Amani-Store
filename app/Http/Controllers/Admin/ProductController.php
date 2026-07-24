<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $products = Product::when($search, function ($query) use ($search) {
            $query->where("title","LIKE","%". $search ."%")
                ->orwhere("description","LIKE","%". $search ."%")
                ->orwhere("stock","LIKE","%". $search ."%")
                ->orwhere("purchase_price","LIKE","%". $search ."%")
                ->orwhere("selling_price","LIKE","%". $search ."%");
        })
            ->orderByDesc('id')
            ->get();
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

        foreach($data['images'] as $index => $img){ 
            $path = $img->store('products','public');
            ProductImages::create([
                'product_id' => $product->id,
                'image' => $path,
                'is_primary' => $index == $data['primary_image']
            ]);
        }
        return to_route('admin.products.index')->with('success','Le produit a été créée avec succès.');
    }

    public function toggle(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();
        $status = $product->is_active ? 'activer' : 'désactiver';
        return back()->with('success',"Le produit a été $status avec succès.");
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        foreach($product->images as $img) {
            Storage::disk('public')->move(
                from : $img->image,
                to   : 'products/trash/' . basename($img->image)
            );
        }
        $product->delete();
        return to_route('admin.products.index')->with("success','Le produit a été supprimer avec succès.");
    }
}
