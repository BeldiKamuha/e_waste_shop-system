<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Events\Supplier;
use App\Http\Requests\SupplierRegisterRequest;

use App\Notifications\SupplierRegNotification;
use Illuminate\Support\Facades\Notification;

class SupplierController extends Controller
{
    public function SupplierDashboard()
    {
        return view('supplier.index');
    }

    public function SupplierLogin()
    {
        return view('supplier.supplier_login');
    }

    public function SupplierDestroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'success'
        );
        return redirect('/login')->with($notification);
    }

    public function SupplierProfile()
    {
        $id = Auth::user()->id;
        $supplierData = User::find($id);
        return view('supplier.supplier_profile_view', compact('supplierData'));
    }

    public function SupplierProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->supplier_join = $request->supplier_join;
        $data->supplier_short_info = $request->supplier_short_info;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/supplier_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/supplier_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Supplier Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function SupplierChangePassword()
    {
        return view('supplier.supplier_change_password');
    }

    public function SupplierUpdatePassword(Request $request)
    {
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
    }

    public function BecomeSupplier()
    {
        return view('auth.become_supplier');
    }

    public function SupplierRegister(Request $request)
{

    $suser = User::where('role','admin')->get();
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'phone' => $request->phone,
        'supplier_join' => $request->supplier_join,
        'password' => Hash::make($request->password),
        'role' => 'supplier', // Ensure role is 'supplier'
        'status' => 'inactive',
    ]);

    $user->sendEmailVerificationNotification();

    $notification = array(
        'message' => 'Supplier Registered Successfully. Please check your email for verification.',
        'alert-type' => 'success'
    );

    event(new Supplier($user));

    Auth::login($user); // Logs in the user

    Notification::send($suser, new SupplierRegNotification($request));
    return redirect()->route('verification.notice')->with('dashboard', 'supplier')->with($notification);

    
}

}

