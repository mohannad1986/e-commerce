<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;

use App\Http\Controllers\CouponsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Admin\OrdersController as AdminOrdersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// اتاحة المسار لجميع المسجلين 
Route::get('/dashboard', function () {
    return view('/dashboard/new');
})->middleware(['auth'])->name('dashboard');

// ++++++++++++++++++++++++++++++++الوصول حسب ال  permmision +++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// 🟩 Super Admin & Admin Permissions

// Route::middleware(['auth', 'permission:manage users'])->group(function () {
//     Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
//     Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
//     Route::post('/users', [UserController::class, 'store'])->name('users.store');
// });

Route::middleware(['auth', 'permission:manage orders'])->group(function () {
    // Route::get('/admin/orders', [AdminOrdersController::class,'index'])->name('admin.orders.index');
});

Route::middleware(['auth', 'permission:manage products'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    });
});

// 🟦 Regular User Permissions ⬇️

Route::middleware(['auth', 'permission:manage users'])->group(function () {
    // 🧑 ملف المستخدم
    Route::get('/users.edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::get('/my-profile', [UsersController::class, 'update'])->name('users.update');
});

Route::middleware(['auth'])->group(function () {
    // 📦 طلباتي (ما بدها صلاحية خاصة لأن أي مستخدم مسجل ممكن يشوف طلباتو)
    Route::get('/my-orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
});


// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++ without auth  ++++++++++++++++++++++++++++++++++++++
Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/seecart', [cartController::class, 'seecart'])->name('seecart');
Route::get('/landing-page.', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/cart', [cartController::class, 'index'])->name('cart.index');
Route::post('/cart', [cartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{product}', [cartController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}',[cartController::class,'switchToSaveForLater'])->name('cart.switchToSaveForLater');
Route::delete('/saveForLater/{product}', [saveForLaterController::class, 'destroy'])->name('saveForLater.destroy');
Route::post('/saveForLater/switchToCart/{product}',[SaveForLaterController::class,'switchToCart'])->name('saveForLater.switchToCart');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
Route::get('/guestCheckout', [CheckoutController::class, 'index'])->name('guestCheckout.index');
Route::post('/checkout',  [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/thankyou', [ConfirmationController::class, 'index'])->name('confirmation.index');
Route::patch('/cart/{product}',[cartController::class, 'update'])->name('cart.update');
Route::post('/coupon', [CouponsController::class,'store'])->name('coupon.store');
Route::delete('/coupon', [CouponsController::class,'destroy'])->name('coupon.destroy');
Route::get('/search',[ShopController::class,'search'])->name('search');
Route::post('/paypal-checkout', 'CheckoutController@paypalCheckout')->name('checkout.paypal');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ta', function () {
    return view('dashboard/ta');
});

Route::get('/new', function () {
    return view('dashboard/new');
});


// راوت  لشوف الكارت 
// Route::view('/carte.', 'cartee');


// ++++++++++++++++++++++++=
/*
|--------------------------------------------------------------------------
| Roles & Permissions Overview
|--------------------------------------------------------------------------
|
| Role: super-admin (ID: 1)
| - Permissions:
|   • manage users
|   • manage products
|   • manage orders
|   • view reports
|
| Role: admin (ID: 2)
| - Permissions:
|   • manage users
|   • manage products
|
| Role: user (ID: 3)
| - Permissions:
|   • manage users
|
*/


// ++++++++++++++++++++++++++++


// Grouped under auth middleware
// +++++++++++++++++++++++++++++++++++++الوصول حسب ال  roles++++++++++++++++++++++++++++==
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
Route::middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/admin/orders', [AdminOrdersController::class,'index'])->name('admin.orders.index');

});

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

//     // ++++++++++++++++++++++++++++
//     Route::prefix('admin')->name('admin.')->group(function () {
//         Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
//         Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
//     });

//     // +++++++++++++++++++++++++++++

// });

// Route::middleware(['auth', 'role:user'])->group(function () {

//     // 🧑 ملف المستخدم
//     Route::get('/users.edit', [UsersController::class, 'edit'])->name('users.edit');
//     Route::get('/my-profile', [UsersController::class, 'update'])->name('users.update');

//     // 📦 طلباتي
//     Route::get('/my-orders', [OrdersController::class, 'index'])->name('orders.index');
//     Route::get('/my-orders/{order}', [OrdersController::class, 'show'])->name('orders.show');

// });

// +++++++++++++++++++++++++++++++++++++k+++++++++++++++++++++++++++++++++++++++++++++++++++++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
