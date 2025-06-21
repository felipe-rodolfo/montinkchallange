<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(protected ProductService $service) {}

    public function index()
    {
        $products = $this->service->all();
        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('products.form', [
            'title' => 'Cadastrar Produto',
        ]);
    }

    public function store(ProductRequest $request)
    {
        $this->service->store($request->validated());
        return redirect()->route('products.create')->with('success', 'Produto cadastrado com sucesso.');
    }

    public function edit(Product $product)
    {
        return view('products.form', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->service->update($product, $request->validated());
        return redirect()->route('products.edit', $product)->with('success', 'Produto atualizado com sucesso.');
    }
}
