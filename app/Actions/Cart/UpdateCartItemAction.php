<?php

namespace App\Actions\Cart;

use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class UpdateCartItemAction
{
    /**
     * Update cart item quantity
     *
     * @param int $cartItemId
     * @param array $data
     * @return CartItem
     * @throws \Exception
     */
    public function execute(int $cartItemId, array $data): CartItem
    {
        return DB::transaction(function () use ($cartItemId, $data) {
            $cartItem = CartItem::with('product')->findOrFail($cartItemId);

            // Verify cart belongs to authenticated user
            if ($cartItem->cart->user_id !== auth()->id()) {
                throw new \Exception('Unauthorized access to cart item');
            }

            // Check stock availability
            if ($cartItem->product->stock_quantity < $data['quantity']) {
                throw new \Exception('Insufficient stock available');
            }

            // Update quantity
            $cartItem->update([
                'quantity' => $data['quantity'],
            ]);

            return $cartItem->fresh();
        });
    }
}
