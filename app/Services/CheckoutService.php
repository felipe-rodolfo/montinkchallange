<?php

namespace App\Services;

use App\Mail\OrderConfirmed;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutService
{
    public function __construct(protected CartService $cart) {}

    public function finalizeOrder(string $cep, string $address, ?string $couponCode = null): Order
    {
        $items = $this->cart->getItens();
        $subtotal = $this->cart->getSubtotal();
        $shipping = $this->cart->calculateShipping($subtotal);
        $discount = $this->getDiscount($couponCode, $subtotal);

        $total = max(0, $subtotal + $shipping - $discount);

        return DB::transaction(function () use ($cep, $address, $items, $subtotal, $shipping, $discount, $total) {
            $order = Order::create([
                'subtotal' => $subtotal,
                'freight' => $shipping,
                'total' => $total,
                'cep' => $cep,
                'address' => $address,
                'status' => 'pendente',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variation' => $item['variation'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);
            }

            $order->load('items.product');

            Mail::to('cliente@teste.com')->send(new OrderConfirmed($order));

            $this->cart->clear();

            return $order;
        });
    }

    private function getDiscount(?string $code, float $subtotal): float
    {
        if (!$code) {
            return 0;
        }

        $coupon = Coupon::where('code', $code)
            ->where('valid_until', '>=', now())
            ->where('min_amount', '<=', $subtotal)
            ->first();

        return $coupon?->value ?? 0;
    }
}
