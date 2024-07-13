<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function CustomerDashboard(){

        $id = Auth::user()->id;
        $customerData = User::find($id);
        return view('index',compact('customerData'));

    } // End Method 

    public function CustomerProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address; 


        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/customer_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/customer_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Customer Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Mehtod

        public function CustomerLogout(Request $request)
        {
            // Invalidate the session
            $request->session()->invalidate();
    
            // Regenerate CSRF token
            $request->session()->regenerateToken();
    
            // Clear the authentication guard
            Auth::guard('web')->logout();
    
            // Redirect to the login page
            return redirect('/login')->with('status', 'Successfully logged out!');
            exit;
        }// End Mehtod 

    public function CustomerUpdatePassword(Request $request){
        // Validation 
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed', 
        ]);

        // Match The Old Password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            return back()->with("error", "Old Password Doesn't Match!!");
        }

        // Update The new password 
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)

        ]);
        return back()->with("status", " Password Changed Successfully");

    } // End Mehtod


} 
 