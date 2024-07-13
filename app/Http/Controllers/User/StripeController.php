<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
use App\Models\User;
use App\Notifications\OrderComplete;
use Illuminate\Support\Facades\Notification;



class StripeController extends Controller
{
    public function CashOrder(Request $request){    
        
        $user = User::where('role','admin')->get();

        if(Session::has('coupon')){
            $total_amount = Session::get('coupon')['total_amount'];
        }else{
            $total_amount = round(Cart::total());
        }

        $order_id = Order::insertGetId([
            'customer_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'adress' => $request->address,
            'post_code' => $request->post_code,
            'notes' => $request->notes,

            'payment_type' => 'Cash On Delivery',
            'payment_method' => 'Cash On Delivery',

            'currency' => 'Ksh',
            'amount' => $total_amount,


            'invoice_no' => 'EOS'.mt_rand(10000000,99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'), 
            'status' => 'pending',
            'created_at' => Carbon::now(),  

        ]);

        // Start Send Email

        $invoice = Order::findOrFail($order_id);

        $data = [

            'invoice_no' => $invoice->invoice_no,
            'amount' => $total_amount,
            'name' => $invoice->name,
            'email' => $invoice->email,

        ];

        Mail::to($request->email)->send(new OrderMail($data));

        // End Send Email 

        $carts = Cart::content();
        foreach ($carts as $cart) {
            // Access supplier_id from options, or default to null if not set
            $supplier_id = isset($cart->options['supplier_id']) ? $cart->options['supplier_id'] : null;
        
            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $cart->id,
                'supplier_id' => $supplier_id,
                'color' => $cart->options['color'] ?? null,
                'size' => $cart->options['size'] ?? null,
                'qty' => $cart->qty,
                'price' => $cart->price,
                'created_at' => Carbon::now(),
            ]);
        } // End Foreach

        if (Session::has('coupon')) {
            Session::forget('coupon');
         }
       
        Cart::destroy();
        $notification = array(
            'message' => 'Your Order Place Successfully',
            'alert-type' => 'success'
        );

        Notification::send($user, new OrderComplete($request->name));
        return redirect()->route('dashboard')->with($notification); 
    }// End Method 

}
