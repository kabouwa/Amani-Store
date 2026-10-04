<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicStorageController extends Controller
{
    public function getFile(string $path)
    {
        abort_unless(
            file_exists( storage_path('app/public/' . $path ) ),
            404
        );

        return response()->file(
            Storage::disk('public')->path($path)
        );
    }
}
