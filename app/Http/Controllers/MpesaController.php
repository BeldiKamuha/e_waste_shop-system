<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Safaricom\Mpesa\Mpesa;

use App\Http\Controllers\Controller;

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

class MpesaController extends Controller
{
    public function stk(Request $request)
    {

        $user = User::where('role','admin')->get();
        // Instantiate the Mpesa class
        $mpesa = new Mpesa();

        // Your Mpesa credentials from .env
        $BusinessShortCode = 174379;
        $LipaNaMpesaPasskey = env('MPESA_LIPA_NA_MPESA_PASSKEY', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919');
        $TransactionType = 'CustomerBuyGoodsOnline';
        $Amount = $request->amount;
        $PartyA = $request->phone_number; // User's phone number
        $PartyB = 8976288; // Your business short code or till number
        $PhoneNumber = $request->phone_number; // User's phone number
        $CallBackURL = 'https://jisortublow.co.ke/payment/stk-callback';
        $AccountReference = 'AccountReference';
        $TransactionDesc = 'TransactionDesc';
        $Remarks = 'Remarks';

        /* Perform STK Push */ 
        $stkPushSimulation = $mpesa->STKPushSimulation(
            $BusinessShortCode,
            $LipaNaMpesaPasskey,
            $TransactionType,
            $Amount,
            $PartyA,
            $PartyB,
            $PhoneNumber,
            $CallBackURL,
            $AccountReference,
            $TransactionDesc,
            $Remarks
        );

        // Introduce a 30-second delay
        sleep(10); // Delay for 30 seconds

        // Code to check if successful
        $order_id = Order::insertGetId([
            'customer_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'adress' => $request->address,
            'post_code' => $request->post_code,
            'notes' => $request->notes,

            'payment_type' => 'Mpesa',
            'payment_method' => 'Mpesa',

            'currency' => 'Ksh',
            'amount' => $request->amount,

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
            'amount' => $request->amount,
            'name' => $invoice->name,
            'email' => $invoice->email,
        ];

        Mail::to($request->email)->send(new OrderMail($data));
        // End Send Email 

        // Save order items
        $carts = Cart::content();
        foreach ($carts as $cart) {
            // Access supplier_id from options, default to null if not set
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
        }

        // Clear session coupon if exists
        if (Session::has('coupon')) {
            Session::forget('coupon');
         }
       
        // Clear cart after order placed
        Cart::destroy();

        // Redirect to dashboard with success message
        $notification = array(
            'message' => 'Your Order Place Successfully',
            'alert-type' => 'success'
        );

        Notification::send($user, new OrderComplete($request->name));
        return redirect()->route('dashboard')->with($notification); 
    }
}