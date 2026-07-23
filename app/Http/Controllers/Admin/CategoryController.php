<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('created_at')->get();
        return view('admin.categories.index',compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|between:3,40|unique:categories,title',
        ]);
        $validated['slug'] = Str::slug($validated['title']);
        Category::create($validated);
        return back()->with('success','La catégorie a été créée avec succès');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'title' => 'required|string|between:3,40|unique:categories,title',
        ]);
        $validated['slug'] = Str::slug($validated['title']);
        $category->update($validated);
        return back()->with('success','La catégorie a été modifiée avec succès');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success','La catégorie a été supprimer avec succès');
    }  
}
