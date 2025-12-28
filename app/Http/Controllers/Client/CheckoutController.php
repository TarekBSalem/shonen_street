<?php

namespace App\Http\Controllers\Client;

use App\Actions\Order\CreateOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CheckoutRequest;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index(): Response|RedirectResponse
    {
        $cart = Cart::with(['items.product'])
            ->where('user_id', auth()->id())
            ->first();

        // Redirect to cart if empty
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('client.cart.index');
        }

        $cartItems = [];
        $subtotal = 0;

        $cartItems = $cart->items->map(function ($item) use (&$subtotal) {
            $itemTotal = $item->product->price * $item->quantity;
            $subtotal += $itemTotal;

            return [
                'id' => $item->id,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'image_url' => $item->product->image ? asset('storage/' . $item->product->image) : null,
                ],
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total' => $itemTotal,
            ];
        });

        $shipping = 10; // $10 flat shipping
        $total = $subtotal + $shipping;

        // Get user information for preloading
        $user = auth()->user();

        return Inertia::render('client/Checkout', [
            'cartItems' => $cartItems,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
            ],
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    /**
     * Process the checkout
     */
    public function store(CheckoutRequest $request, CreateOrderAction $action): RedirectResponse
    {
        try {
            $order = $action->execute(auth()->user(), $request->validated());

            return redirect()->route('client.orders.show', $order->id)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}
