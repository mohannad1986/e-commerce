<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Gloudemans\Shoppingcart\Facades\Cart;


class SaveForLaterController extends Controller
{
    public function destroy($id)
    {
        Cart::instance('saveForLater')->remove($id);

        return back()->with('success_message', 'Item has been removed!');
    }


    public function switchToCart($id)
    {
        $item = Cart::instance('saveForLater')->get($id);

        Cart::instance('saveForLater')->remove($id);

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already in your Cart!');
        }

        Cart::instance('default')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success_message', 'Item has been moved to Cart!');
    }
}
