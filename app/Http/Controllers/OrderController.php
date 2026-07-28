<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }
    public function store(OrderRequest $request)
    {
        $data = $request->validated();

        return view('orders.confirmed');
    }
}
