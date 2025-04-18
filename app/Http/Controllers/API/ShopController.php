<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\helpers\helpers;


class ShopController extends Controller
{
  

    public function index(Request $request)
{
    $pagination = 9;

    // قاعدة المنتجات
    $productsQuery = Product::with('categories');

    // فلترة حسب الكاتيجوري (إذا موجود)
    if ($request->has('category')) {
        $productsQuery->whereHas('categories', function ($query) use ($request) {
            $query->where('slug', $request->category);
        });

        $category = Category::where('slug', $request->category)->first();
        $categoryName = $category ? $category->name : 'Unknown';
    } else {
        // عشوائي لأول مرة بدون فلترة
        $productsQuery->inRandomOrder()->take(12);
        $categoryName = 'Featured';
    }

    // فرز حسب السعر إذا مطلوب
    if ($request->sort === 'low_high') {
        $productsQuery->orderBy('price');
    } elseif ($request->sort === 'high_low') {
        $productsQuery->orderByDesc('price');
    }

    // جلب المنتجات مع الباجينيت
    $products = $productsQuery->paginate($pagination);

    // جلب جميع التصنيفات
    $categories = Category::all();

    return response()->json([
        'products' => $products,
        'categories' => $categories,
        'category_name' => $categoryName,
    ]);
}  

public function show($slug)
{   

    $product = Product::where('slug', $slug)->first();


    if (!$product) {
        return response()->json([
            'status' => 'error',
            'message' => 'Product not found'
        ], 404);
    }
    $product->image = url('storage/' . $product->image); // مثال إذا كانت الصور مخزنة في `public/storage`

    $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();

    foreach ($mightAlsoLike as $item) {
        $item->image = url('storage/' . $item->image); // إضافة المسار الكامل للصورة
    }
    return response()->json([
        'status' => 'success',
        'product' => $product,
        'mightAlsoLike' => $mightAlsoLike
    ], 200);
}



public function searchProducts(Request $request)
{ 
   
    $query = $request->input('query');
    $products = Product::search($query)->get();

    return response()->json([
        'status' => 'success',
        'products' => $products
    ]);
}




}
