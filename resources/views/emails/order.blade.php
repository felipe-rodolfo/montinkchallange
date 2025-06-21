<h2>Pedido Confirmado!</h2>
<p><strong>Endereço:</strong> {{ $order->address }}</p>

<h4>Itens:</h4>
<ul>
    @foreach($order->items as $item)
        <li>{{ $item->product->name }} ({{ $item->variation ?? 'sem variação' }}) x {{ $item->quantity }}</li>
    @endforeach
</ul>

<p><strong>Frete:</strong> R$ {{ number_format($order->shipping, 2, ',', '.') }}</p>
<p><strong>Total:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}</p>
