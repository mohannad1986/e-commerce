<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Bus;


use App\Jobs\UpdateCoupon;


class CartUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {   
        // يتحقق مما إذا كان هناك كوبون مخزن في الجلسة.
        // إذا كان الكوبون موجودًا، فإنه يأخذ اسم الكوبون (الكود الخاص به).
        $coupon = session()->get('coupon');
        $couponName = isset($coupon['name']) ? $coupon['name'] : null;
        
        if ($couponName) {
            $coupon = Coupon::where('code', $couponName)->first();
        
            if ($coupon) { // تحقق أن الكوبون موجود في قاعدة البيانات
                // session()->put('coupon', [
                //     'name' => $coupon->code,
                //     'discount' => $coupon->discount(Cart::subtotal()),
                // ]);
                // dispatch_now(new UpdateCoupon($coupon));
                Bus::dispatchSync(new UpdateCoupon($coupon));

            }
        }

        
        // dispatch_now(new UpdateCoupon($coupon));
       
    }
}
