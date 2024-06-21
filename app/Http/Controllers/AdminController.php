<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard(){

        return view('admin.index');

    } //End Method

    public function AdminLogin(){
        return view('admin.admin_login');

    }

    public function AdminDestroy(Request $request){
    
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    } // End Mehtod
    
    public function AdminProfile(){

        $id= Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));

    }//End Method

    public function AdminProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        
        if ($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }//End Method

    public function AdminChangePassword(){
        return view('admin.admin_change_password');

    }//End Method

    public function AdminUpdatePassword(Request $request){
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

    public function InactiveSupplier(){
        $inActiveSupplier = User::where('status','inactive')->where('role','supplier')->latest()->get();
        return view('backend.supplier.inactive_supplier',compact('inActiveSupplier'));

    }// End Mehtod
    public function ActiveSupplier(){
        $ActiveSupplier = User::where('status','active')->where('role','supplier')->latest()->get();
        return view('backend.supplier.active_supplier',compact('ActiveSupplier'));

    }// End Mehtod

    public function InactiveSupplierDetails($id){

        $inactiveSupplierDetails = User::findOrFail($id);
        return view('backend.supplier.inactive_supplier_details',compact('inactiveSupplierDetails'));

    }// End Mehtod 

    public function ActiveSupplierApprove(Request $request){

        $supplier_id = $request->id;
        $user = User::findOrFail($supplier_id)->update([
            'status' => 'active',
        ]);

        $notification = array(
            'message' => 'Supplier Active Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('active.supplier')->with($notification);

    }// End Mehtod 

    public function ActiveSupplierDetails($id){

        $activeSupplierDetails = User::findOrFail($id);
        return view('backend.supplier.active_supplier_details',compact('activeSupplierDetails'));

    }// End Mehtod 

    public function InActiveSupplierApprove(Request $request){

        $supplier_id = $request->id;
        $user = User::findOrFail($supplier_id)->update([
            'status' => 'inactive',
        ]);

        $notification = array(
            'message' => 'Supplier InActive Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('inactive.supplier')->with($notification);

    }// End Mehtod 


}
