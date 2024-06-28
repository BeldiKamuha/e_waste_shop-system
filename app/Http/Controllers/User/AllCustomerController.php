<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;

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

}