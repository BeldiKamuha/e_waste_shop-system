<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;

class CheckoutController extends Controller
{

    public function CheckoutStore(Request $request){

        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
       
        $data['shipping_address'] = $request->shipping_address;
        $data['notes'] = $request->notes; 
        $cartTotal = Cart::total();

        if ($request->payment_option == 'stripe') {
           return view('frontend.payment.stripe',compact('data','cartTotal'));
        }elseif ($request->payment_option == 'card'){
            return 'Card Page';
        }else{
            return view('frontend.payment.cash',compact('data','cartTotal'));
        }


    }// End Method 
}
