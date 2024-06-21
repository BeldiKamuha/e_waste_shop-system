<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User; 
use App\Models\Product; 
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function SupplierDetails($id){

        $supplier = User::findOrFail($id);
        $sproduct = Product::where('supplier_id',$id)->get();
        return view('frontend.supplier.supplier_details',compact('supplier','sproduct'));

     } // End Method

}
