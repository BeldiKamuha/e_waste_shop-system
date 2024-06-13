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

public function SupplierStoreProduct(Request $request){


    $image = $request->file('product_thambnail');
    $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
    Image::make($image)->resize(800,800)->save('upload/products/thambnail/'.$name_gen);
    $save_url = 'upload/products/thambnail/'.$name_gen;

    $product_id = Product::insertGetId([

        'brand' => $request->brand,
        'category' => $request->category,
        'subcategory_id' => $request->subcategory_id,
        'product_name' => $request->product_name,
        'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

        'product_code' => $request->product_code,
        'product_qty' => $request->product_qty,
        'product_tags' => $request->product_tags,
        'product_size' => $request->product_size,
        'product_color' => $request->product_color,

        'selling_price' => $request->selling_price,
        'discount_price' => $request->discount_price,
        'short_descp' => $request->short_descp,
        'supplier_id' => Auth::user()->id,

        'hot_deals' => $request->hot_deals,
        'featured' => $request->featured,
        'special_offer' => $request->special_offer,
        'special_deals' => $request->special_deals, 

        'product_thambnail' => $save_url,
      
        'status' => 1,
        'created_at' => Carbon::now(), 

    ]);

    /// Multiple Image Upload From her //////

    $images = $request->file('multi_img');
    foreach($images as $img){
        $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
    Image::make($img)->resize(800,800)->save('upload/products/multi-image/'.$make_name);
    $uploadPath = 'upload/products/multi-image/'.$make_name;


    MultiImg::insert([

        'product_id' => $product_id,
        'photo_name' => $uploadPath,
        'created_at' => Carbon::now(), 

    ]); 
    } // end foreach

    /// End Multiple Image Upload From her //////

    $notification = array(
        'message' => 'Supplier Product Inserted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('supplier.all.product')->with($notification); 


} // End Method 


  
}