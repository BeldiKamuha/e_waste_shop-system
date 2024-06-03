<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\NewPasswordController;




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

Route::group(['middleware' => 'prevent-back-history'], function() {
    

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth','verified'])->group(function() {
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
});

    
// Group Milldeware End

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//     Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// require __DIR__.'/auth.php';

/// Admin Dashboard

Route::middleware(['auth','role:admin'])->group(function() {
Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');
Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('update.password');


});

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::put('reset-password', [NewPasswordController::class, 'store'])
     ->name('password.update');




// Route::get('/admin/login', [AdminController::class, 'AdminLogin']);
// Route::get('/supplier/login', [SupplierController::class, 'SupplierLogin'])->name('supplier.login');
Route::get('/become/supplier', [SupplierController::class, 'BecomeSupplier'])->name('become.supplier');
Route::post('/supplier/register', [SupplierController::class, 'SupplierRegister'])->name('supplier.register');

 // Email verification
    Route::middleware(['auth', 'signed'])->group(function () {
        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            $user = $request->user();

            // Determine the redirection URL based on user role
            $redirectUrl = match($user->role) {
                'admin' => route('admin.dashboard'),
                'supplier' => route('/supplier/dashboard'),
                'customer' => route('dashboard'),
                default => route('login'), // Redirect to login if role is not recognized
            };

            return redirect()->intended($redirectUrl);
        })->name('verification.verify');
    });
});

// Load authentication routes
require __DIR__.'/auth.php';