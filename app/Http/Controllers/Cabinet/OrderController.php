<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Показывает список заказов текущего пользователя
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return view('cabinet.orders.index', compact('orders'));
    }

    /**
     * Показ конкретного заказа (по желанию)
     */
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403); // Защита от чужих заказов
        }

        return view('cabinet.orders.show', compact('order'));
    }

    public function invoice(Order $order)
{
    $this->authorize('view', $order);

    $pdf = \PDF::loadView('cabinet.orders.invoice', compact('order'));
    return $pdf->download("invoice-order-{$order->id}.pdf");
}

}
