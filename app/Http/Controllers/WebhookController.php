<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status' => 'required|string',
        ]);

        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json(['error' => 'Pedido não encontrado'], 404);
        }

        if (strtolower($request->status) === 'cancelado') {
            $order->delete();
            return response()->json(['message' => 'Pedido cancelado e removido'], 200);
        }

        $order->update(['status' => $request->status]);

        return response()->json(['message' => 'Status atualizado com sucesso'], 200);
    }
}
