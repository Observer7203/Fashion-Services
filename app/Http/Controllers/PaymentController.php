<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->input('order_id'));

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => config('paypal.currency', 'EUR'),
                    'value' => number_format($order->total, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'cancel_url' => route('payment.cancel'),
                'return_url' => route('payment.success'),
            ],
        ]);

        if (isset($response['id']) && $response['status'] === 'CREATED') {
            Payment::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'provider' => 'paypal',
                'payment_id' => $response['id'],
                'amount' => $order->total,
                'currency' => config('paypal.currency', 'EUR'),
                'status' => 'created',
            ]);

            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->back()->withErrors('Payment creation failed');
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->get('token'));

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $payment = Payment::where('payment_id', $response['id'])->first();
            if ($payment) {
                $payment->update(['status' => 'completed']);
                $payment->order?->update(['status' => 'paid']);
            }
            return redirect()->route('cabinet')->with('success', 'Payment successful');
        }

        return redirect()->route('cabinet')->withErrors('Payment failed');
    }

    public function cancel()
    {
        return redirect()->route('cabinet')->withErrors('Payment cancelled');
    }
}
