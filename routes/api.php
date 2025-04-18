<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ShopController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refreshToken']);
// +++++++++++++++++++++++++++++++++++++++
    // مثال لاستخدام Middleware للتحقق من الأدوار
    // لسماح بالدخول بناءً على الادوار 
    Route::get('/admin-dashboard', function () {
        return response()->json(['message' => 'Welcome Admin']);
    })->middleware('role:admin');

    Route::get('/super-admin-dashboard', function () {
        return response()->json(['message' => 'Welcome super- Admin']);
    })->middleware('role:super-admin');
    // ++++++++++++++++++++++++++++++++++++++++++


    // ++++++++++++++++++++++++++++++++++++++++++++
     // السماح بالدخول بناءً على الصلاحيات
     Route::middleware('permission:access admin dashboard')->get('/admin-dashboard', function () {
        return response()->json(['message' => 'Welcome Admin']);
    });

    Route::middleware('permission:access super-admin dashboard')->get('/super-admin-dashboard', function () {
        return response()->json(['message' => 'Welcome Super Admin']);
    });

    // ++++++++++++++++++++++++++++++++++++++++++++++


});

use App\Http\Controllers\API\CheckoutController;

Route::post('/checkout', [CheckoutController::class, 'store']);

Route::post('/cart/summary', [CheckoutController::class, 'cartSummary']);


Route::get('/shop', [ShopController::class, 'index']);

Route::get('/products/{slug}', [ShopController::class, 'show']);
Route::get('product/search', [ShopController::class, 'searchProducts']);





