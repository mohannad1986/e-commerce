<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\CardException;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Coupon;


class CheckoutController extends Controller
{  
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function cartSummary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'coupon' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $totals = $this->calculateTotals($request);

        return response()->json([
            'products' => $totals['products'],
            'subtotal' => $totals['subtotal'],
            'discount' => $totals['discount'],
            'discountCode' => $totals['discountCode'],
            'tax' => $totals['tax'],
            'total' => $totals['total'],
        ]);
    }
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++   

    protected function calculateTotals(Request $request)
    {
        $subtotal = 0;
        $productDetails = [];

        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $quantity = $productData['quantity'];
            // الارقام في قاعدة البيانات محفزظة بالسنت وليس بلدولار لهك عم نقسمها ع مية 
            // يعني الغرض الي مكتوب عليه 100 يعني سعرو 1 دولار 
            $subtotal += ($product->price / 100) * $productData['quantity'];

            $productDetails[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price / 100,

                'quantity' => $quantity,
            ];
        }

        $discount = 0;
        $discountCode = null;

        if ($request->filled('coupon')) {
            $discountRecord = coupon::where('code', $request->coupon)->first();
            if ($discountRecord) {
                $discount = $discountRecord->discount($subtotal);
                $discountCode = $discountRecord->code;
            }
        }

        $newSubtotal = max($subtotal - $discount, 0);
        $taxRate = config('cart.tax') / 100;
        $tax = $newSubtotal * $taxRate;
        $total = $newSubtotal + $tax;

        return [
            'products' => $productDetails,
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'discountCode' => $discountCode,
            'tax' => round($tax, 2),
            'total' => round($total, 2),
        ];
    }


    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // +++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function store(Request $request)
    {
        // ✅ التحقق من صحة البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'stripeToken' => 'required|string',
            'email' => 'required|email',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
   


        // ++++++++++++++++++++++++++++++++++++++++++

        $totals = $this->calculateTotals($request);
        $totalAmountCents = round($totals['total'] * 100); // Stripe يعمل بالسنتات


        try {
            // ✅ تنفيذ عملية الدفع عبر Stripe
            $charge = Stripe::charges()->create([
                'amount' => $totalAmountCents,
                'currency' => 'CAD',
                'source' => $request->stripeToken,
                'description' => 'E-commerce Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'products' => json_encode($totals['products']),
                    'total_quantity' => collect($request->products)->sum('quantity'),
                ]
            ]);

            // ✅ حفظ الطلب في قاعدة البيانات
            $order=$this->addToOrdersTable($request, null, $totals);
            // ✅ تحديث كميات المنتجات في المخزون
            $this->decreaseProductQuantities($request->products);

            return response()->json([
                'success' => true,
                'message' => 'Payment successful!',
                'order' => $order,
            ], 200);

        } catch (CardException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error processing payment: ' . $e->getMessage()
            ], 400);
        }
    }

   
    

    private function decreaseProductQuantities($products)
    {
        foreach ($products as $productData) {
            $product= Product::where('id', $productData['id'])->first();;

            $product->update(['quantity' => $product->quantity -$productData['quantity']]);
        }
    }

    protected function addToOrdersTable($request, $error, $totals)
    {
        // Insert into orders table
        $user = JWTAuth::parseToken()->authenticate();
        $billingEmail = $user ? $user->email : $request->email;

        $order = Order::create([

             'user_id' => $user ? $user->id : null,

            // 'user_id' => auth()->user() ? auth()->user()->id : null,
            // 'billing_email' => $request->email,
            'billing_email' => $billingEmail,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->name_on_card,
            'billing_subtotal' => $totals['subtotal'],
            'billing_discount_code' => $totals['discountCode'],
            'billing_discount' => $totals['discount'],
            'billing_tax' => $totals['tax'],
            'billing_total' => $totals['total'],

            // +++++++++++++++++++

            

            'error' => $error,

        ]);
        return $order;

}
}