<?php

namespace App\Http\Controllers;
use App\Models\Coupon;

use Illuminate\Http\Request;
use App\Jobs\UpdateCoupon;

use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Support\Facades\Bus;


class CouponsController extends Controller
{
    public function store(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return back()->withErrors('Invalid coupon code. Please try again.');
        }
        // dispatch_now(new UpdateCoupon($coupon));
        // dispatch_now(new UpdateCoupon($coupon));
        //  dispatchSync(new UpdateCoupon($coupon));
        Bus::dispatchSync(new UpdateCoupon($coupon));



        // session()->put('coupon',[
        //     'name'=>$coupon->code,
        //     'discount'=>$coupon->discount(cart::subtotal()),
        // ]);
        return back()->with('success_message', 'Coupon has been applied!');
    }
    
    public function destroy()
    {
        session()->forget('coupon');

        return back()->with('success_message', 'Coupon has been removed.');
    }
}
