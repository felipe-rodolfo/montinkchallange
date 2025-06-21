@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Carrinho</h2>
    <a href="{{ route('products.index') }}">Listar produtos</a>

    <hr>
    @if(count($items) === 0)
        <p>Carrinho vazio.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Variação</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['variation'] ?? '-' }}</td>
                        <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove') }}">
                                @csrf
                                <input type="hidden" name="key" value="{{ $item['_key'] }}">
                                <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
        <p><strong>Frete:</strong> R$ {{ number_format($shipping, 2, ',', '.') }}</p>
        <p><strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>
    @endif
</div>
@endsection
