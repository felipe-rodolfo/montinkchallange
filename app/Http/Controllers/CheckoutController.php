<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function index()
    {
        $items = $this->cart->getItens();
        $subtotal = $this->cart->getSubtotal();
        $shipping = $this->cart->calculateShipping($subtotal);
        $total = $this->cart->getTotal();

        return view('checkout.index', compact('items', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cep' => 'required|regex:/^\d{5}-?\d{3}$/',
            'endereco' => 'required|string|max:255',
        ]);

        return redirect()->route('checkout.index')->with('success', 'Pedido finalizado!');
    }
}
