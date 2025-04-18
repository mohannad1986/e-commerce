<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class OrdersController extends Controller
{
    //
    public function index()
    {
        $orders = auth()->user()->orders; // n + 1 issues

        // $orders = auth()->user()->orders()->with('products')->get(); // fix n + 1 issues

        return view('my-orders')->with('orders', $orders);
    }


    public function show(Order $order)
    {
        if (auth()->id() !== $order->user_id) {
            return back()->withErrors('You do not have access to this!');
        }

        $products = $order->products;

        return view('my-order')->with([
            'order' => $order,
            'products' => $products,
        ]);
    }
}
