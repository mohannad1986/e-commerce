<?php

namespace App\Http\Controllers;

use  App\Models\Product;


use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Contracts\Calculator;

use Gloudemans\Shoppingcart\Contracts\Buyable;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;




class CartController extends Controller 
{ 
   public function index()
    { 
    // مايت اولوو لايك هو  لوكال سكوب مووجود بموديل البرودكت 
    $mightAlsoLike = Product::mightAlsoLike()->get();
    $tax = config('cart.tax') / 100;
    $discount = session()->get('coupon')['discount'] ?? 0;
    $newSubtotal = ((float) Cart::subtotal() - (float) $discount);
    // $newSubtotal = (Cart::subtotal() - $discount);

    $newTax = $newSubtotal * $tax;
    $newTotal = $newSubtotal * (1 + $tax);
    return view('cart')->with([
        'mightAlsoLike' => $mightAlsoLike,
        // 'discount' => getNumbers()->get('discount'),
        // 'newSubtotal' => getNumbers()->get('newSubtotal'),
        // 'newTax' => getNumbers()->get('newTax'),
        // 'newTotal' => getNumbers()->get('newTotal'),
        'discount' => $discount,
        'newSubtotal' =>$newSubtotal ,
        'newTax' => $newTax,
        'newTotal' =>$newTotal ,
    ]);

    }

    public function store(Request $request)
    {  


     
        Cart::add($request->id,$request->name, 1, $request->price)->associate('App\Models\Product');
        // ستخدم associate() لربط العنصر في سلة التسوق بنموذج (Model) معين.
// الهدف هو استرجاع كامل بيانات المنتج عند استعراض السلة، بدلاً من مجرد تخزين بيانات بسيطة مثل الاسم والسعر فقط
// @foreach (Cart::content() as $item)
// <p>{{ $item->model->description }}</p>  <!-- هنا نستخدم بيانات المنتج المرتبطة بالسلة -->
// @endforeach

        return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart!');

    }




    public function update(Request $request, $id)
    {  
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if ($validator->fails()) {
            session()->flash('errors', collect(['Quantity must be between 1 and 5.']));
            return response()->json(['success' => false], 400);
        }

        if ($request->quantity > $request->productQuantity) {
            session()->flash('errors', collect(['We currently do not have enough items in stock.']));
            return response()->json(['success' => false], 400);
        }

        Cart::update($id, $request->quantity);
        session()->flash('success_message', 'Quantity was updated successfully!');
        return response()->json(['success' => true]);
    }
  

    public function destroy($id)
    {   

        Cart::remove($id);

        return back()->with('success_message', 'Item has been removed!');
    }


    public function switchToSaveForLater($id)
    {
        $item = Cart::get($id);

        Cart::remove($id);
        $duplicates = Cart::instance('saveForLater')->add($item->id,$item->name, 1, $item->price)->associate('App\Models\Product'); 


        
        return redirect()->route('cart.index')->with('success_message', 'Item has been Saved For Later!');
    }


    public function seecart(){

        dd(Cart::content());
    }

 
}
