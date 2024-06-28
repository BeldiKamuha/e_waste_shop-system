<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem; 
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;

class SupplierOrderController extends Controller
{
    public function SupplierOrder(){

        $id = Auth::user()->id;
        $orderitem = OrderItem::with('order')->where('supplier_id',$id)->orderBy('id','DESC')->get();
        return view('supplier.backend.orders.pending_orders',compact('orderitem'));
    } // End Method 


}