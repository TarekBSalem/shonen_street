<?php

namespace App\Actions\Order;

use App\Events\OrderCreated;
use App\Jobs\SendLowStockNotification;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateOrderAction
{
    /**
     * Create an order from the user's cart
     *
     * @param User $user
     * @param array $data
     * @return Order
     * @throws \Exception
     */
    public function execute(User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            // Get user's cart with items
            $cart = Cart::with(['items.product'])
                ->where('user_id', $user->id)
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($cart->items as $item) {
                // Check stock availability
                if ($item->product->stock_quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$item->product->name}");
                }
                $subtotal += $item->price * $item->quantity;
            }

            $shipping = 10; // $10 flat shipping
            $total = $subtotal + $shipping;

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => json_encode([
                    'name' => $data['shipping_name'],
                    'email' => $data['shipping_email'],
                    'phone' => $data['shipping_phone'],
                    'address' => $data['shipping_address'],
                    'city' => $data['shipping_city'],
                    'state' => $data['shipping_state'],
                    'zip' => $data['shipping_zip'],
                    'country' => $data['shipping_country'],
                ]),
            ]);

            // Create order items and update stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price_at_purchase' => $item->product->price,
                ]);

                // Decrease stock
                $item->product->decrement('stock_quantity', $item->quantity);
                
                // Reload product to get updated stock
                $item->product->refresh();
                
                // Check if stock is low (less than 10 units) and dispatch notification job
                if ($item->product->stock_quantity < 10 && $item->product->stock_quantity >= 0) {
                    SendLowStockNotification::dispatch($item->product);
                }
            }

            // Clear cart
            $cart->items()->delete();

            // Dispatch event
            event(new OrderCreated($order));

            return $order;
        });
    }
}
