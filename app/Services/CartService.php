<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function add(Product $product, ?string $variation = null)
    {
        $cart = Session::get('cart', []);

        $key = $product->id . '-' . ($variation ?? 'padrao');

        if (!isset($cart[$key])) {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'variation' => $variation,
                'price' => $product->price,
                'quantity' => 1,
            ];
        } else {
            $cart[$key]['quantity']++;
        }

        Session::put('cart', $cart);
    }

    public function getItens()
    {
        return Session::get('cart', []);
    }

    public function getSubtotal()
    {
        return collect($this->getItens())->reduce(function ($cart, $item) {
            return $cart + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function calculateShipping(float $subtotal)
    {
        return match (true) {
            $subtotal >= 52 && $subtotal <= 166.59 => 15.00,
            $subtotal > 200 => 0.00,
            default => 20.00,
        };
    }

    public function getTotal()
    {
        $subtotal = $this->getSubtotal();
        $shipping = $this->calculateShipping($subtotal);
        return $subtotal + $shipping;
    }

    public function remove(string $key): void
    {
        $cart = session('cart', []);

        unset($cart[$key]);

        session(['cart' => $cart]);
    }
}
