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
use Barryvdh\DomPDF\Facade\Pdf;

class SupplierOrderController extends Controller
{
    public function SupplierPendingOrder(){
        $supplier_id = Auth::user()->id;
        
        // Fetch the orders with status 'pending' where the supplier ID matches
        $orders = Order::where('status', 'pending')
                        ->whereHas('orderItems', function ($query) use ($supplier_id) {
                            $query->where('supplier_id', $supplier_id);
                        })
                        ->with(['orderItems' => function ($query) use ($supplier_id) {
                            $query->where('supplier_id', $supplier_id);
                        }])
                        ->orderBy('id', 'DESC')
                        ->get();
        return view('supplier.backend.orders.pending_orders',compact('orders'));
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
    
        return view('supplier.backend.orders.supplier_order_details', compact('order', 'orderItems'));
    }// End Method 

    public function SupplierConfirmedOrder()
    {
        $supplier_id = Auth::user()->id;
        
        // Fetch the orders with status 'confirm' where the supplier ID matches
        $orders = Order::where('status', 'confirm')
                        ->whereHas('orderItems', function ($query) use ($supplier_id) {
                            $query->where('supplier_id', $supplier_id);
                        })
                        ->with(['orderItems' => function ($query) use ($supplier_id) {
                            $query->where('supplier_id', $supplier_id);
                        }])
                        ->orderBy('id', 'DESC')
                        ->get();
        
        return view('supplier.backend.orders.confirmed_orders', compact('orders'));
    }// End Method  
    
    public function SupplierProcessingOrder(){

        $supplier_id = Auth::user()->id;
        
        // Fetch the orders with status 'processing' where the supplier ID matches
        $orders = Order::where('status', 'processing')
                        ->whereHas('orderItems', function ($query) use ($supplier_id) {
                            $query->where('supplier_id', $supplier_id);
                        })
                        ->with(['orderItems' => function ($query) use ($supplier_id) {
                            $query->where('supplier_id', $supplier_id);
                        }])
                        ->orderBy('id', 'DESC')
                        ->get();
        return view('supplier.backend.orders.processing_orders', compact('orders'));
    } // End Method
    
    public function SupplierDeliveredOrder(){

        $supplier_id = Auth::user()->id;
        
        // Fetch the orders with status 'delivered' where the supplier ID matches
        $orders = Order::where('status', 'delivered')
                        ->whereHas('orderItems', function ($query) use ($supplier_id) {
                            $query->where('supplier_id', $supplier_id);
                        })
                        ->with(['orderItems' => function ($query) use ($supplier_id) {
                            $query->where('supplier_id', $supplier_id);
                        }])
                        ->orderBy('id', 'DESC')
                        ->get();
        return view('supplier.backend.orders.delivered_orders', compact('orders'));
    } // End Method

    public function PendingToConfirm($order_id){
        Order::findOrFail($order_id)->update(['status' => 'confirm']);

        $notification = array(
            'message' => 'Order Confirm Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.confirmed.order')->with($notification); 


    }// End Method 

    public function ConfirmToProcess($order_id){
        Order::findOrFail($order_id)->update(['status' => 'processing']);

        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.processing.order')->with($notification); 


    }// End Method 

    public function ProcessToDelivered($order_id){
        Order::findOrFail($order_id)->update(['status' => 'delivered']);

        $notification = array(
            'message' => 'Order Delivered Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.delivered.order')->with($notification); 


    }// End Method 

    public function SupplierInvoiceDownload($order_id){

        $order = Order::with('user')->where('id',$order_id)->first();
        $orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();
    
        $pdf = Pdf::loadView('supplier.backend.orders.supplier_order_invoice', compact('order','orderItem'))->setPaper('a4')->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
        ]);
        return $pdf->download('invoice.pdf');
    
    }// End Method

}


 