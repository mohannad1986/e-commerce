<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use    App\Models\Product;

class LandingPageController extends Controller
{
    // +++++++++++++++++=
    public function index()
    {
        // $products = Product::where('featured', true)->take(8)->inRandomOrder()->get();
        $products = Product::take(8)->inRandomOrder()->get();


        return view('landing-page')->with('products', $products);
    }

    // ++++++++++++++++++++++=
}
