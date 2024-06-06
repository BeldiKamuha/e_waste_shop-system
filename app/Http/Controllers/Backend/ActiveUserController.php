<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ActiveUserController extends Controller
{
    public function AllCustomer(){
        $customers = User::where('role','customer')->latest()->get();
        return view('backend.user.customer_all_data',compact('customers'));

    } // End Mehtod 

    public function AllSupplier(){
        $suppliers = User::where('role','supplier')->latest()->get();
        return view('backend.user.supplier_all_data',compact('suppliers'));

    } // End Mehtod 



}