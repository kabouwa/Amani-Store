<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrivateStorageController extends Controller
{
    public function supplierImage(Supplier $supplier)
    {
        return response()
            ->file(
                Storage::disk('private')->path($supplier->image)
            );
    }

}
