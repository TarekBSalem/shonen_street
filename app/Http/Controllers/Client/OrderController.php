<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Display the order confirmation page
     */
    public function show(int $orderId): Response
    {
        $order = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->findOrFail($orderId);

        $orderData = [
            'id' => $order->id,
            'total_amount' => $order->total_price,
            'status' => $order->status,
            'shipping_address' => json_decode($order->shipping_address, true),
            'created_at' => $order->created_at->toISOString(),
            'items' => $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product' => [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'image_url' => $item->product->image ? asset('storage/' . $item->product->image) : null,
                    ],
                    'quantity' => $item->quantity,
                    'price' => $item->price_at_purchase,
                ];
            }),
        ];

        return Inertia::render('client/OrderConfirmation', [
            'order' => $orderData,
        ]);
    }
}
