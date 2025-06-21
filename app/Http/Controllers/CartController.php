<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variation' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $this->cart->add($product, $request->variation);

        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho.');
    }

    public function index()
    {

        $data = $this->cart->getItens();
        $items = [];
        foreach ($data as $key => $item) {
            $item['_key'] = $key;
            $items[] = $item;
        }

        $subtotal = $this->cart->getSubtotal();
        $shipping = $this->cart->calculateShipping($subtotal);
        $total = $this->cart->getTotal();

        return view('cart.index', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function remove(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $this->cart->remove($request->key);

        return redirect()->route('cart.index')->with('success', 'Produto removido do carrinho.');
    }
}
