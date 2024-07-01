<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;

class AllCustomerController extends Controller
{
    public function CustomerAccount(){
        $id = Auth::user()->id;
        $customerData = User::find($id);
        return view('frontend.customerdashboard.account_details',compact('customerData'));

    } // End Method 

    public function CustomerChangePassword(){
        return view('frontend.customerdashboard.customer_change_password' );
   } // End Method 

   public function CustomerOrderPage(){

    $id = Auth::user()->id;
        $orders = Order::where('customer_id',$id)->orderBy('id','DESC')->get();
          return view('frontend.customerdashboard.customer_order_page',compact('orders'));
}// End Method 

public function CustomerOrderDetails($order_id){

    $order = Order::with('user')->where('id',$order_id)->where('customer_id',Auth::id())->first();
    $orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();

    return view('frontend.order.order_details',compact('order','orderItem'));

}// End Method 

public function CustomerOrderInvoice($order_id){

    $order = Order::with('user')->where('id',$order_id)->where('customer_id',Auth::id())->first();
    $orderItem = OrderItem::with('product')->where('order_id',$order_id)->orderBy('id','DESC')->get();

    $pdf = Pdf::loadView('frontend.order.order_invoice', compact('order','orderItem'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
    ]);
    return $pdf->download('invoice.pdf');

}// End Method

}