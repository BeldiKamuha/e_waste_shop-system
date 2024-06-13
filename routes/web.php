<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Backend\ActiveUserController;
use App\Http\Controllers\Backend\SupplierProductController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

 // Prevent Back Middleware

// Route::group(['middleware' => 'prevent-back-history'], function() {


/// Customer Dashboard

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth', 'verified'])->group(function() {
Route::get('/dashboard', [CustomerController::class, 'CustomerDashboard'])->name('dashboard');
Route::post('/customer/profile/store', [CustomerController::class, 'CustomerProfileStore'])->name('customer.profile.store');
Route::get('/customer/logout', [CustomerController::class, 'CustomerLogout'])->name('customer.logout');
Route::post('/customer/update/password', [CustomerController::class, 'CustomerUpdatePassword'])->name('customer.update.password');

}); 


/// Supplier Dashboard

    Route::middleware(['auth', 'verified', 'role:supplier'])->group(function() {
    Route::get('/supplier/login', [SupplierController::class, 'SupplierLogin'])->name('supplier.login');
    Route::get('/supplier/dashboard', [SupplierController::class, 'SupplierDashboard'])->name('supplier.dashboard');
    Route::get('/supplier/logout', [SupplierController::class, 'SupplierDestroy'])->name('supplier.logout');
    Route::get('/supplier/profile', [SupplierController::class, 'SupplierProfile'])->name('supplier.profile');
    Route::post('/supplier/profile/store', [SupplierController::class, 'SupplierProfileStore'])->name('supplier.profile.store');
    Route::get('/supplier/change/password', [SupplierController::class, 'SupplierChangePassword'])->name('supplier.change.password');
    Route::post('/supplier/update/password', [SupplierController::class, 'SupplierUpdatePassword'])->name('supplier.update.password');


    // Supplier Add Product All Route

        Route::controller(SupplierProductController::class)->group(function(){
        Route::get('/supplier/all/product' , 'SupplierAllProduct')->name('supplier.all.product');
        Route::get('/supplier/add/product' , 'SupplierAddProduct')->name('supplier.add.product');
        Route::post('/supplier/store/product' , 'SupplierStoreProduct')->name('supplier.store.product');
    
    });

});


/// Admin Dashboard

Route::middleware(['auth','role:admin'])->group(function() {
Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');


});


// Supplier Active and Inactive All Route 
Route::controller(AdminController::class)->group(function(){
Route::get('/inactive/supplier' , 'InactiveSupplier')->name('inactive.supplier');
Route::get('/active/supplier' , 'ActiveSupplier')->name('active.supplier');
Route::get('/inactive/supplier/details/{id}' , 'InactiveSupplierDetails')->name('inactive.supplier.details');
Route::post('/active/supplier/approve' , 'ActiveSupplierApprove')->name('active.supplier.approve');
Route::get('/active/supplier/details/{id}' , 'ActiveSupplierDetails')->name('active.supplier.details');
Route::post('/inactive/supplier/approve' , 'InActiveSupplierApprove')->name('inactive.supplier.approve');

});


Route::controller(ActiveUserController::class)->group(function(){

    Route::get('/all/customer' , 'AllCustomer')->name('all-customer');
    Route::get('/all/supplier' , 'AllSupplier')->name('all-supplier');


});


Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::put('reset-password', [NewPasswordController::class, 'store'])->name('password.update');


Route::get('/become/supplier', [SupplierController::class, 'BecomeSupplier'])->name('become.supplier');
Route::post('/supplier/register', [SupplierController::class, 'SupplierRegister'])->name('supplier.register');

// Email verification
Route::middleware(['auth', 'signed'])->group(function () {
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        $user = $request->user();

        // Determine the redirection URL based on user role
        $redirectUrl = match($request->query('dashboard')) {
            'supplier' => route('supplier.dashboard'),
            'admin' => route('admin.dashboard'),
            default => route('dashboard'), // Redirect to default dashboard if role is not recognized
        };

        return redirect()->intended($redirectUrl);
    })->name('verification.verify');
});


// });

// Load authentication routes
require __DIR__.'/auth.php';









// Group Milldeware End

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//     Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::get('/admin/login', [AdminController::class, 'AdminLogin']);
// Route::get('/supplier/login', [SupplierController::class, 'SupplierLogin'])->name('supplier.login');

// require __DIR__.'/auth.php';