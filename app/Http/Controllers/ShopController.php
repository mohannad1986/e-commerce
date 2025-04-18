<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\helpers\helpers;

class ShopController extends Controller
{
    public function index()
    {   

        $pagination = 9;
        // لتحقق إذا تم طلب فلترة حسب الكاتيغوري:
        // ذا كان هناك باراميتر category في الـ URL (مثلاً: ?category=clothes) 
        // فـ الكود يجيب كل المنتجات اللي تابعة لهالكاتيغوري.
        if (request()->category) {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            });
            $categories = Category::all(); 
            $categoryName = optional($categories->where('slug', request()->category)->first())->name;
        }
        
        else{
        $products = Product::take(12)->inRandomOrder();
        $categories = Category::all();
        $categoryName='Featured';

        
    }
    if (request()->sort == 'low_high') {
        $products = $products->orderBy('price')->paginate($pagination);
    } elseif (request()->sort == 'high_low') {
        $products = $products::orderByDesc('price')->paginate($pagination);
    } else {
        $products = $products->paginate($pagination);
    }



        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
        ]);
    }


    public function show($slug)
    {

        $product = Product::where('slug', $slug)->firstOrFail();

        $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();
        //   $stockLevel = getStockLevel($product->quantity);


        return view('product')->with([
            'product' => $product,
            // 'stockLevel' => $stockLevel,
            'mightAlsoLike' => $mightAlsoLike,
        ]);
    }


    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|min:3',
        ]);

        $query = $request->input('query');
        //  بدون الباكج
        // $products = Product::where('name', 'like', "%$query%")
        //                    ->orWhere('details', 'like', "%$query%")
        //                    ->orWhere('description', 'like', "%$query%")
        //                    ->paginate(10);
        // باستخدام الباكج  تبع نيوكولا

        $products = Product::search($query)->paginate(10);

        return view('search-results')->with('products', $products);
    }

    


   
    
}

