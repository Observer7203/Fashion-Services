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
    
        $view = match ($product->type) {
            'jewelry' => 'partials.store.item-jewelry',
            'wear' => 'partials.store.item-wear',
            'tour' => 'partials.store.item-tour',
            'service' => 'partials.store.item-service',
            default => 'store.show',
        };
    
        return view($view, compact('product'));
    }    
}