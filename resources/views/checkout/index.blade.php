@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Finalizar Pedido</h2>

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf

        <div class="mb-3">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" name="cep" id="cep" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <input type="text" name="endereco" id="endereco" class="form-control" required>
        </div>

        <h4>Resumo do Pedido</h4>
        <ul class="list-group mb-3">
            @foreach($items as $item)
                <li class="list-group-item">
                    {{ $item['name'] }} {{ $item['variation'] ? '(' . $item['variation'] . ')' : '' }} x {{ $item['quantity'] }} — 
                    R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                </li>
            @endforeach
        </ul>

        <p><strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
        <p><strong>Frete:</strong> R$ {{ number_format($shipping, 2, ',', '.') }}</p>
        <p><strong>Total:</strong> R$ {{ number_format($total, 2, ',', '.') }}</p>
    </form>
</div>

<script>
    document.getElementById('cep').addEventListener('blur', async function () {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length !== 8) return;

        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
            alert('CEP não encontrado!');
            return;
        }

        const endereco = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
        document.getElementById('endereco').value = endereco;
    });
</script>
@endsection
