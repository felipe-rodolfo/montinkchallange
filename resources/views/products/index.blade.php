@extends('layouts.app')

@section('content')

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Variação</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['variations'] }}</td>
                        <td>R$ {{ number_format($product['price'], 2, ',', '.') }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>R$ {{ number_format($product['total'], 2, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.add') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                <input type="text" name="variation" placeholder="Variação (opcional)" class="form-control mb-2">
                                <button type="submit" class="btn btn-success">Comprar</button>
                            </form>
                        </td>

                        <td>
                            <form method="get" action="{{ route('products.edit', $product['id']) }}">
                                @csrf
                                <button type="submit" class="btn btn-link">Editar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection