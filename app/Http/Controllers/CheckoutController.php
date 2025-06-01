<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use App\Http\Requests\CheckoutRequest;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Helpers\helpers;
use Illuminate\Support\Facades\Mail;

// use App\mail\OrderPlaced;
use App\Mail\OrderPlaced;

use App\Jobs\SendOrderPlacedEmail;


class CheckoutController extends Controller
{
    public function index()
    {  
    //     انا بجي لهون من راوين 
    //    guestCheckout
    //    و 
    //    Checkout
    // في حال السلة فاضية خدني ه شوب 
        if (Cart::instance('default')->count() == 0) {
            return redirect()->route('shop.index');
        }
        //  اذا ضغطت فوق عالرابط وكبتتguestCheckout
        // وكمن انت  مسجل دخول 
        // ح يرجعك لصفحة اشيك اوت الخاصة بالمسجلين 
        // صراحة هني نفس الصفحة بس اكل خرا 
        if (auth()->user() && request()->is('guestCheckout')) {
            return redirect()->route('checkout2.index');
        }

        // +++++++++++++++++++++++++
        // هذا الجزء يقوم بإنشاء كائن من Braintree Gateway 
        // باستخدام المفاتيح المخزنة في ملف الإعدادات config/services.php.
        // Gateway هو الكائن الذي يمثل الاتصال بين تطبيقك و Braintree.
        // $gateway = new \Braintree\Gateway([
        //     'environment' => config('services.braintree.environment'),
        //     'merchantId' => config('services.braintree.merchantId'),
        //     'publicKey' => config('services.braintree.publicKey'),
        //     'privateKey' => config('services.braintree.privateKey')
        // ]);
        // بعد ذلك يتم توليد التوكن:
        // try {
        //     $paypalToken = $gateway->ClientToken()->generate();
        // } catch (\Exception $e) {
        //     $paypalToken = null;
        // }
        $paypalToken = null;

        // +++++++++++++++++++++++++
       
        return view('checkout2')->with([
     
            'paypalToken' => $paypalToken,
            'discount' => getNumbers()->get('discount'),
            'newSubtotal' => getNumbers()->get('newSubtotal'),
            'newTax' => getNumbers()->get('newTax'),
            'newTotal' => getNumbers()->get('newTotal'),
        ]);
    }
    
    // CheckoutRequest
    public function store(CheckoutRequest $request)
    {  
        // dd($request->all());
        // ++++++++++++++++++++++++++++++++++++ 
        
          // Check race condition when there are less items available to purchase
        //    حالة خاصة اسمها race 
        // ممكن انت تشوف بالعرض في غرض وباقي منو 1 وبنفس الوقت بينم تروح لتشتريه 
        // بيكون غيرك اشتراه وقتاح يعط ايرور بالداتا بيس وقيمة سالبة لنتجنب هالحالة  هون تحقق 
          if ($this->productsAreNoLongerAvailable()) {
            return back()->withErrors('Sorry! One of the items in your cart is no longer avialble.');
        }



        $contents = Cart::content()->map(function ($item) {
            return $item->model->slug.', '.$item->qty;
        })->values()->toJson();
        try {
            $charge = Stripe::charges()->create([
                // هنا يتم ارسال القيمة 
                'amount' => floatval(getNumbers()->get('newTotal'),) / 100,
                'currency' => 'CAD',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                        'discount' => collect(session()->get('coupon'))->toJson(),
                ]
                         
            ]);

            $order = $this->addToOrdersTables($request, null);

            Mail::send(new OrderPlaced($order));
            // تجربة 
            // ارسال الايميل عن طريق الجوب 
            // SendOrderPlacedEmail::dispatch($order);

            // // decrease the quantities of all the products in the cart
            $this->decreaseQuantities();
            Cart::instance('default')->destroy();
            session()->forget('coupon');
            // return back()->with('success_message' . 'grate');
           return redirect()->route('confirmation.index')->with('success_message', 'Thank you! Your payment has been successfully accepted!');
        } catch (CardErrorException $e) {
            // هذا لتحفظ ال  error  في الداتا بيس 
            $this->addToOrdersTables($request, $e->getMessage());
            return back()->withErrors('Error! ' . $e->getMessage());
        }

    }

    protected function addToOrdersTables($request, $error)
    {
        // Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->name_on_card,
            'billing_discount' => getNumbers()->get('discount'),
            'billing_discount_code' => getNumbers()->get('code'),
            'billing_subtotal' => getNumbers()->get('newSubtotal'),
            'billing_tax' => getNumbers()->get('newTax'),
            'billing_total' => getNumbers()->get('newTotal'),
            'error' => $error,
        ]);

        // Insert into order_product table
        // ممكن يكون اكثر من برودكت في كل اورد
        //  لهك بندخل اكثر من سجل في  هذا الجدول حسب عدد المنتجات في الطلب
        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
            ]);
        }

        return $order;
    }


    protected function decreaseQuantities()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);

            $product->update(['quantity' => $product->quantity - $item->qty]);
        }
    }


    protected function productsAreNoLongerAvailable()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);
            if ($product->quantity < $item->qty) {
                return true;
            }
        }

        return false;
    }

}
