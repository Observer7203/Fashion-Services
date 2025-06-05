<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function create()
    {
        $ids = Session::get('bucket', []);
        $products = Product::whereIn('id', $ids)->get();

        if ($products->isEmpty()) {
            return redirect()->route('store.bucket.index')->withErrors(['Корзина пуста']);
        }

        return view('store.checkout', compact('products'));
    }

    public function store(Request $request)
    {
        $ids = Session::get('bucket', []);
        $products = Product::whereIn('id', $ids)->get();

        if ($products->isEmpty()) {
            return redirect()->route('store.index')->withErrors(['Корзина пуста']);
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total' => $products->sum('price'),
        ]);

        foreach ($products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'type' => 'product',
                'item_id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => 1,
            ]);
        }

        Session::forget('bucket');

        return redirect()->route('cabinet')->with('success', 'Заказ оформлен');
    }
}
