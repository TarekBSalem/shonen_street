<?php

namespace App\Http\Controllers\Client;

use App\Actions\Cart\AddToCartAction;
use App\Actions\Cart\RemoveFromCartAction;
use App\Actions\Cart\UpdateCartItemAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\AddToCartRequest;
use App\Http\Requests\Client\UpdateCartItemRequest;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index(): Response
    {
        $cart = Cart::with(['items.product'])
            ->where('user_id', auth()->id())
            ->first();

        $cartItems = [];
        $subtotal = 0;

        if ($cart) {
            $cartItems = $cart->items->map(function ($item) use (&$subtotal) {
                $itemTotal = $item->product->price * $item->quantity;
                $subtotal += $itemTotal;

                return [
                    'id' => $item->id,
                    'product' => [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'stock_quantity' => $item->product->stock_quantity,
                        'image_url' => $item->product->image ? asset('storage/' . $item->product->image) : null,
                    ],
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'total' => $itemTotal,
                ];
            });
        }

        $shipping = $subtotal > 0 ? 10 : 0; // $10 flat shipping
        $total = $subtotal + $shipping;

        return Inertia::render('client/Cart', [
            'cartItems' => $cartItems,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
            ],
        ]);
    }

    /**
     * Add a product to the cart
     */
    public function add(AddToCartRequest $request, AddToCartAction $action): RedirectResponse
    {
        $action->execute(auth()->user(), $request->validated());

        return back()->with('success', 'Product added to cart successfully');
    }

    /**
     * Update cart item quantity
     */
    public function update(UpdateCartItemRequest $request, int $cartItemId, UpdateCartItemAction $action): RedirectResponse
    {
        $action->execute($cartItemId, $request->validated());

        return back()->with('success', 'Cart updated successfully');
    }

    /**
     * Remove item from cart
     */
    public function remove(int $cartItemId, RemoveFromCartAction $action): RedirectResponse
    {
        $action->execute($cartItemId);

        return back()->with('success', 'Item removed from cart');
    }
}
