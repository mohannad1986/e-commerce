<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\Controller;


class OrdersController extends Controller
{
    //
    public function index()
    {  

        $orders = Order::with('user')->get(); // جلب الطلبات مع بيانات المستخدم المرتبطة
         return view('dashboard.orders.index', compact('orders'));
       
    }


    public function show(Order $order)
    {
      
    }
}
