<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // Каталог товаров
    public function index()
    {
        $products = Product::where('status', 'active')->latest()->paginate(12);
        return view('store.index', compact('products'));
    }

    // Страница товара
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('store.show', compact('product'));
    }
}