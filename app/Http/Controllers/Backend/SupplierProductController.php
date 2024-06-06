<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\MultiImg;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Image;
use Carbon\Carbon;
use Auth;

class SupplierProductController extends Controller
{
     public function SupplierAllProduct(){

        // $id = Auth::user()->id;
        $products = Product::latest()->get();
        return view('supplier.backend.product.supplier_product_all',compact('products'));
    } // End Method 

    public function SupplierAddProduct(){

        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('supplier.backend.product.supplier_product_add',compact('brands','categories'));

    } // End Method 


//  public function SupplierGetSubCategory($category_id){
//         $subcat = SubCategory::where('category_id',$category_id)->orderBy('subcategory_name','ASC')->get();
//             return json_encode($subcat);

//     }// End Method 


}