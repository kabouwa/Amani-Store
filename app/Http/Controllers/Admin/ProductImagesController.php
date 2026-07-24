<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;

class ProductImagesController extends Controller
{
    public function primary(ProductImages $productImages, Product $product)
    {
        $product->images()->update([
            'is_primary' => false
        ]);
        
        $productImages->is_primary = true;
        $productImages->save();

        return back()->with('success',"L'image principale a été modifiée avec succès.");
    }
    public function destroy(ProductImages $productImages)
    {
        if($productImages->is_primary) return back();
        $productImages->delete();
        return back()->with('success',"L'image a été supprimée avec succès.");
    }
}
