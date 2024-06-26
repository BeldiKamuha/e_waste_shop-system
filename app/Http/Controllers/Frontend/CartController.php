<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Auth;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $price = $product->discount_price ?? $product->selling_price;

            Cart::add([
                'id' => $id,
                'name' => $product->product_name,
                'qty' => $request->quantity,
                'price' => $price,
                'weight' => 1,
                'options' => [
                    'image' => $product->product_thumbnail,
                    'color' => $request->color,
                    'size' => $request->size,
                    'supplier_id' => $request->supplier_id,
                ],
            ]);

            return response()->json(['success' => 'Successfully added to your cart']);
        } catch (\Exception $e) {
            \Log::error('Error adding product to cart: ' . $e->getMessage());
            return response()->json(['error' => 'Error adding product to cart'], 500);
        }
    }

    public function AddMiniCart()
    {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return response()->json([
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal
        ]);
    } // End Method

    public function RemoveMiniCart($rowId) {
        Cart::remove($rowId);
    
        // Assuming you want to return a success message
        return response()->json(['success' => 'Product removed from cart successfully']);
    }// End Method

    public function MyCart() {
        return view('frontend.mycart.view_mycart');
    }  // End Method
    
    public function GetCartProduct() {
        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();
    
        return response()->json([
            'carts' => $carts,
            'cartQty' => $cartQty,
            'cartTotal' => $cartTotal
        ]);
    }  // End Method

    public function RemoveCartProduct($rowId) {
        Cart::remove($rowId);
        return response()->json(['success' => 'Product removed from cart']);
    }// End Method

    public function UpdateCartQuantity(Request $request) {
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        return response()->json(['success' => 'Cart quantity updated']);
    } // End Method

    public function CheckoutCreate(){

        if (Auth::check()) {

            if (Cart::total() > 0) { 

        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();

        return view('frontend.checkout.checkout_view',compact('carts','cartQty','cartTotal'));


            }else{

            $notification = array(
            'message' => 'Shopping At list One Product',
            'alert-type' => 'error'
        );

        return redirect()->to('/')->with($notification); 
            }



        }else{

             $notification = array(
            'message' => 'You Need to Login First',
            'alert-type' => 'error'
        );

        return redirect()->route('login')->with($notification); 
        }




    }// End Method

}