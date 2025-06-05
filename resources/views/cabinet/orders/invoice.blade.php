<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Квитанция №{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; }
        .bold { font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .total { text-align: right; margin-top: 20px; font-size: 16px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Квитанция об оплате</h2>
        <p>Заказ №{{ $order->id }} от {{ $order->created_at->format('d.m.Y') }}</p>
        <img src="{{ public_path('images/logo.png') }}" alt="Логотип" style="height: 60px; margin-bottom: 10px;">
    </div>

    <p><span class="bold">Покупатель:</span> {{ $order->user->name }}</p>
    <p><span class="bold">Email:</span> {{ $order->user->email }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ number_format($item->price, 2) }} €</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Итого к оплате: {{ number_format($order->total, 2) }} €
    </div>

    <p style="margin-top: 40px;">Спасибо за ваш заказ!</p>

    <div style="margin-top: 40px;">
    <p class="bold">Реквизиты продавца:</p>
    <p>ИП Baktygul Bulatkali</p>
    <p>Счет: FR76 3000 4000 0000 0000 0000 000 (CCF Bank)</p>
    <p>IBAN / BIC: CCFBFRPPXXX</p>
    <p>Email: hello@baktygul.com</p>
    </div>

    <div style="margin-top: 60px;">
    <p>Подпись администратора:</p>
    <img src="{{ public_path('images/signature.png') }}" alt="Подпись" style="height: 50px;">
    </div>

</body>
</html>
