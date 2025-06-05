<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BucketController extends Controller
{
    public function index()
    {
        $items = Session::get('bucket', []);
        return view('store.bucket.index', compact('items'));
    }

    public function add(Request $request, $productId)
    {
        $bucket = Session::get('bucket', []);
        $bucket[] = $productId;
        Session::put('bucket', $bucket);

        return redirect()->route('store.bucket.index')->with('success', 'Товар добавлен в корзину');
    }

    public function remove($productId)
    {
        $bucket = Session::get('bucket', []);
        $bucket = array_filter($bucket, fn($id) => $id != $productId);
        Session::put('bucket', $bucket);

        return redirect()->route('store.bucket.index')->with('success', 'Товар удалён из корзины');
    }
}
