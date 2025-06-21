@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($product) ? 'Editar Produto' : 'Cadastrar Produto' }}</h2>
    <a class="btn btn-link" href="{{ route('products.index') }}">Listar produtos</a>
    <hr>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops! Algo deu errado.</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Preço</label>
            <input type="text" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Variações (opcional)</label>
            <input type="text" name="variations[]" class="form-control mb-1" placeholder="Ex: Tamanho M">
            <input type="text" name="variations[]" class="form-control mb-1" placeholder="Ex: Tamanho G">
        </div>

        <h5>Estoque por variação</h5>
        <div id="estoque-container">
            <div class="row mb-2">
                <div class="col">
                    <input type="text" name="stocks[0][variation]" class="form-control" placeholder="Variação (ex: M)">
                </div>
                <div class="col">
                    <input type="number" name="stocks[0][quantity]" class="form-control" placeholder="Quantidade">
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="adicionarEstoque()">+ Adicionar Estoque</button>

        <button type="submit" class="btn btn-primary mb-3">Salvar</button>
    </form>
</div>

<script>
    let contador = 1;
    function adicionarEstoque() {
        const container = document.getElementById('estoque-container');
        const linha = `
            <div class="row mb-2">
                <div class="col">
                    <input type="text" name="estoques[${contador}][variacao]" class="form-control" placeholder="Variação (ex: M)">
                </div>
                <div class="col">
                    <input type="number" name="estoques[${contador}][quantidade]" class="form-control" placeholder="Quantidade">
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', linha);
        contador++;
    }
</script>
@endsection
