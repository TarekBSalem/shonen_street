<?php

namespace App\Actions\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AddToCartAction
{
    /**
     * Add a product to the user's cart
     *
     * @param User $user
     * @param array $data
     * @return CartItem
     * @throws \Exception
     */
    public function execute(User $user, array $data): CartItem
    {
        return DB::transaction(function () use ($user, $data) {
            // Get or create cart for user
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);

            // Check if product exists and has sufficient stock
            $product = Product::findOrFail($data['product_id']);

            if ($product->stock_quantity < $data['quantity']) {
                throw new \Exception('Insufficient stock available');
            }

            // Check if item already exists in cart
            $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $data['product_id'])->first();

            if ($cartItem) {
                // Update quantity if item exists
                $newQuantity = $cartItem->quantity + $data['quantity'];

                if ($product->stock_quantity < $newQuantity) {
                    throw new \Exception('Insufficient stock available');
                }

                $cartItem->update([
                    'quantity' => $newQuantity,
                    'price' => $product->price,
                ]);
            } else {
                // Create new cart item
                $cartItem = CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'price' => $product->price,
                ]);
            }

            return $cartItem;
        });
    }
}
