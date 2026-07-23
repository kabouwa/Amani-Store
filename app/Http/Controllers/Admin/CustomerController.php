<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $customers = Customer::when($search, function ($query) use ($search) {
            $query->where("name","LIKE","%". $search ."%")
                ->orwhere("phone","LIKE","%". $search ."%")
                ->orwhere("instagram","LIKE","%". $search ."%")
                ->orwhere("address","LIKE","%". $search ."%");
        })
        ->orderByDesc('id')
        ->get();
        return view('admin.customers.index',compact('customers'));
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->back()->with('success','Le client et sa commande a été supprimer avec succès');
    }
}
