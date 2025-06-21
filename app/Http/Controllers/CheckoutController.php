<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cart, protected CheckoutService $checkout) {}

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
            'address' => 'required|string|max:255',
        ]);

        $this->checkout->finalizeOrder(
            $request->cep,
            $request->address,
            $request->coupon
        );

        return redirect()->route('products.index')->with('success', 'Pedido finalizado!');
    }
}
