<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\NewPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\Backend\ActiveUserController;
use App\Http\Controllers\Backend\SupplierProductController;
use App\Http\Controllers\Backend\SupplierOrderController;
use App\Http\Controllers\Backend\AdminOrderController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\StripeController;
use App\Http\Controllers\User\AllCustomerController;







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

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

/// Customer Dashboard

Route::get('/', function () {
    return view('frontend.index');
});

Route::middleware(['auth', 'verified'])->group(function() {
Route::get('/dashboard', [CustomerController::class, 'CustomerDashboard'])->name('dashboard');
Route::post('/customer/profile/store', [CustomerController::class, 'CustomerProfileStore'])->name('customer.profile.store');
Route::get('/customer/logout', [CustomerController::class, 'CustomerLogout'])->name('customer.logout');
Route::post('/customer/update/password', [CustomerController::class, 'CustomerUpdatePassword'])->name('customer.update.password');

    // Cart All Route 
    Route::controller(CartController::class)->group(function(){
    Route::get('/mycart', 'MyCart')->name('mycart');
    Route::get('/get-cart-product', 'GetCartProduct');
    Route::get('/cart-remove/{rowId}', 'RemoveCartProduct');
    Route::post('/cart-update-quantity', 'UpdateCartQuantity');
});

   //  Route for CheckoutStore
   Route::post('/checkout/store', [CheckoutController::class, 'CheckoutStore'])->name('checkout.store');

    // Stripe All Route 
    Route::controller(StripeController::class)->group(function(){
    Route::post('/cash/order' , 'CashOrder')->name('cash.order');
}); 

// M-PESA all route
Route::controller(MpesaController::class)->group(function(){
    Route::post('/mpesa/order', 'stk')->name('mpesa.order');
    Route::post('/mpesa/stk-status', 'checkStkStatus')->name('mpesa.stk.status');
});

// Customer Dashboard All Route 
    Route::controller(AllCustomerController::class)->group(function(){
    Route::get('/customer/account/page' , 'CustomerAccount')->name('customer.account.page');
    Route::get('/customer/change/password' , 'CustomerChangePassword')->name('customer.change.password');
    Route::get('/customer/order/page' , 'CustomerOrderPage')->name('customer.order.page');
    Route::get('/customer/order_details/{order_id}' , 'CustomerOrderDetails');
    Route::get('/customer/invoice_download/{order_id}' , 'CustomerOrderInvoice');

});  

});  // end Supplier Group middleware



/// Supplier Dashboard

    Route::middleware(['auth', 'verified', 'role:supplier'])->group(function() {
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
        Route::get('/supplier/edit/product/{id}' , 'SupplierEditProduct')->name('supplier.edit.product');
        Route::post('/supplier/update/product' , 'SupplierUpdateProduct')->name('supplier.update.product');
        Route::post('/supplier/update/product/thambnail' , 'SupplierUpdateProductThabnail')->name('supplier.update.product.thambnail');
        Route::post('/supplier/update/product/multiimage' , 'SupplierUpdateProductmultiImage')->name('supplier.update.product.multiimage');
        Route::get('/supplier/product/multiimg/delete/{id}' , 'SupplierMultiimgDelete')->name('supplier.product.multiimg.delete');
        Route::get('/supplier/product/inactive/{id}' , 'SupplierProductInactive')->name('supplier.product.inactive');
        Route::get('/supplier/product/active/{id}' , 'SupplierProductActive')->name('supplier.product.active');
        Route::get('/supplier/delete/product/{id}' , 'SupplierProductDelete')->name('supplier.delete.product');
    
    });


 // Supplier Order All Route 
    Route::controller(SupplierOrderController::class)->group(function(){
    Route::get('/supplier/pending/order' , 'SupplierPendingOrder')->name('supplier.pending.order');
    Route::get('/supplier/order/details/{order_id}', 'SupplierOrderDetails')->name('supplier.order.details');
    Route::get('/supplier/confirmed/order' , 'SupplierConfirmedOrder')->name('supplier.confirmed.order');
    Route::get('/supplier/processing/order' , 'SupplierProcessingOrder')->name('supplier.processing.order');
    Route::get('/supplier/delivered/order' , 'SupplierDeliveredOrder')->name('supplier.delivered.order');

    Route::get('/pending/confirm/{order_id}' , 'PendingToConfirm')->name('pending-confirm');
    Route::get('/confirm/processing/{order_id}' , 'ConfirmToProcess')->name('confirm-processing');
    Route::get('/processing/delivered/{order_id}' , 'ProcessToDelivered')->name('processing-delivered');

    Route::get('/supplier/invoice/download/{order_id}' , 'SupplierInvoiceDownload')->name('supplier.invoice.download');



});


}); // end Supplier Group middleware


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

    // Admin Order All Route 
    Route::controller(AdminOrderController::class)->group(function(){
    Route::get('/pending/order' , 'PendingOrder')->name('pending.order');
    Route::get('/admin/order/details/{order_id}' , 'AdminOrderDetails')->name('admin.order.details');

    Route::get('/admin/confirmed/order' , 'AdminConfirmedOrder')->name('admin.confirmed.order');

    Route::get('/admin/processing/order' , 'AdminProcessingOrder')->name('admin.processing.order');
 
    Route::get('/admin/delivered/order' , 'AdminDeliveredOrder')->name('admin.delivered.order');

    Route::get('/pending/confirm/{order_id}' , 'PendingToConfirm')->name('pending-confirm');
    Route::get('/confirm/processing/{order_id}' , 'ConfirmToProcess')->name('confirm-processing');

    Route::get('/processing/delivered/{order_id}' , 'ProcessToDelivered')->name('processing-delivered');

    Route::get('/admin/invoice/download/{order_id}' , 'AdminInvoiceDownload')->name('admin.invoice.download');
    
    
    });

     // Report All Route 
Route::controller(ReportController::class)->group(function(){

    Route::get('/report/view' , 'ReportView')->name('report.view');
    Route::post('/search/by/date' , 'SearchByDate')->name('search-by-date');
    Route::post('/search/by/month' , 'SearchByMonth')->name('search-by-month');
    Route::post('/search/by/year' , 'SearchByYear')->name('search-by-year');

    Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
    Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');




});

// Site Setting All Route 
    Route::controller(SiteSettingController::class)->group(function(){

    Route::get('/site/setting' , 'SiteSetting')->name('site.setting');
    Route::post('/site/setting/update' , 'SiteSettingUpdate')->name('site.setting.update');
   
   });


}); // end Admin Group middleware


// Password Reset Routes
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::put('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');


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



});



// Load authentication routes
require __DIR__.'/auth.php';



/// Frontend Product Details All Route 
Route::get('/supplier/details/{id}', [IndexController::class, 'SupplierDetails'])->name('supplier.details');
Route::get('/supplier/all', [IndexController::class, 'SupplierAll'])->name('supplier.all');

// Example web.php route definition
Route::get('/', [IndexController::class, 'index']);



/// Add to cart store data
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);

// Get Data from mini Cart
Route::get('/product/mini/cart', [CartController::class, 'AddMiniCart']);

Route::get('/minicart/product/remove/{rowId}', [CartController::class, 'RemoveMiniCart']);
// Checkout Page Route 
Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');

// Mpsa  Route 
Route::get('/pay', [MpesaController::class, 'stk']);





// Group Milldeware End






