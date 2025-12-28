<?php

namespace App\Actions\Cart;

use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class RemoveFromCartAction
{
    /**
     * Remove item from cart
     *
     * @param int $cartItemId
     * @return bool
     * @throws \Exception
     */
    public function execute(int $cartItemId): bool
    {
        return DB::transaction(function () use ($cartItemId) {
            $cartItem = CartItem::findOrFail($cartItemId);

            // Verify cart belongs to authenticated user
            if ($cartItem->cart->user_id !== auth()->id()) {
                throw new \Exception('Unauthorized access to cart item');
            }

            return $cartItem->delete();
        });
    }
}
