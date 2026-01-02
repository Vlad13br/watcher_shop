<h1>Дякуємо за замовлення!</h1>

<p>Номер замовлення: {{ $order['id'] }}</p>
<p>Користувач: {{ $order['user']['name'] }} ({{ $order['user']['email'] }})</p>
<p>Метод оплати: {{ $order['payment_method'] }}</p>
<p>Адреса доставки: {{ $order['place'] }}</p>

<h3>Товари:</h3>
<ul>
    @foreach($order['orderItems'] as $item)
        <li>{{ $item['product_name'] }} - {{ $item['quantity'] }} шт. - {{ number_format($item['price'], 2) }} грн</li>
    @endforeach
</ul>

<p>Статус доставки: {{ $order['shipping_status'] }}</p>
