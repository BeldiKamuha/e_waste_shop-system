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

    public function SupplierOrderDetails($order_id) {
        $supplier_id = Auth::user()->id;
    
        // Fetch the order where the supplier ID matches and the order ID matches
        $order = Order::with('user')->where('id', $order_id)->whereHas('orderItems', function($query) use ($supplier_id) {
            $query->where('supplier_id', $supplier_id);
        })->first();
    
        // If no order is found, handle it (e.g., redirect back with an error message)
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found or you do not have access to this order.');
        }
    
        // Fetch the order items where the order ID matches and the supplier ID matches
        $orderItems = OrderItem::with('product')->where('order_id', $order_id)->where('supplier_id', $supplier_id)->orderBy('id', 'DESC')->get();
    
        return view('backend.orders.supplier_order_details', compact('order', 'orderItems'));
    }// End Method 

    public function SupplierConfirmedOrder(){
        $supplierId = Auth::user()->id;
        $orderitem = Order::where('status', 'confirm')
                            ->whereHas('orderItems', function($query) use ($supplierId) {
                                $query->where('supplier_id', $supplierId);
                            })
                            ->orderBy('id', 'DESC')
                            ->get();
        return view('backend.orders.confirmed_orders', compact('orderitem'));
    } // End Method
    
    public function SupplierProcessingOrder(){
        $supplierId = Auth::user()->id;
        $orderitem = Order::where('status', 'processing')
                            ->whereHas('orderItems', function($query) use ($supplierId) {
                                $query->where('supplier_id', $supplierId);
                            })
                            ->orderBy('id', 'DESC')
                            ->get();
        return view('backend.orders.processing_orders', compact('orderitem'));
    } // End Method
    
    public function SupplierDeliveredOrder(){
        $supplierId = Auth::user()->id;
        $orderitem = Order::where('status', 'deliverd')
                            ->whereHas('orderItems', function($query) use ($supplierId) {
                                $query->where('supplier_id', $supplierId);
                            })
                            ->orderBy('id', 'DESC')
                            ->get();
        return view('backend.orders.delivered_orders', compact('orderitem'));
    } // End Method
}
