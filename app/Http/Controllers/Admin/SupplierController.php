<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return view("admin.suppliers.index", compact('suppliers'));
    }

    public function create()
    {
        $supplier = new Supplier();
        return view("admin.suppliers.create", compact('supplier'));
    }

    public function store(SupplierRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('private')
                ->putFile('suppliers', $request->file('image'));
        }

        Supplier::create($data);

        return to_route('admin.suppliers.index')->with('success', 'Le fournisseur a été ajouté avec succès.');
    }

    public function edit(Supplier $supplier)
    {
        return view("admin.suppliers.edit", compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Soft delete previous Images
            $this->moveImageToTrash($supplier->image);

            // Save new image
            $data['image'] = Storage::disk('private')
                ->putFile('suppliers', $request->file('image'));
        }

        $supplier->update($data);

        return to_route('admin.suppliers.index')->with('success', 'Le fournisseur a été modifié avec succès.');
    }

    public function destroy(Supplier $supplier)
    {
        // Soft delete image
        $this->moveImageToTrash($supplier->image);

        $supplier->delete();

        return back()->with('success', 'Le fournisseur a été supprimé avec succès.');
    }


    public function moveImageToTrash(?string $path): void
    {
        $image = $path;

        if($image) {
            Storage::disk('private')
                ->move(
                    $image,
                    'suppliers/trash/' . basename($image)
                );
        }
    }
}
