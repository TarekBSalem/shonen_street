<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Order\UpdateOrderStatusAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request): Response
    {
        $query = Order::with(['user'])->withCount('items');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by order ID or user name
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate(15)->withQueryString();

        // Transform orders
        $orders->getCollection()->transform(function ($order) {
            return [
                'id' => $order->id,
                'user' => [
                    'id' => $order->user->id,
                    'name' => $order->user->name,
                    'email' => $order->user->email,
                ],
                'total_amount' => $order->total_price,
                'status' => $order->status,
                'items_count' => $order->items_count,
                'created_at' => $order->created_at->toISOString(),
            ];
        });

        // Get status counts for filters
        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return Inertia::render('admin/orders/Index', [
            'orders' => $orders,
            'filters' => [
                'status' => $request->status,
                'search' => $request->search,
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
            ],
            'statusCounts' => $statusCounts,
        ]);
    }

    /**
     * Display the specified order
     */
    public function show(int $orderId): Response
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($orderId);

        $orderData = [
            'id' => $order->id,
            'user' => [
                'id' => $order->user->id,
                'name' => $order->user->name,
                'email' => $order->user->email,
            ],
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'shipping_address' => json_decode($order->shipping_address, true),
            'created_at' => $order->created_at->toISOString(),
            'updated_at' => $order->updated_at->toISOString(),
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
                    'total' => $item->price_at_purchase * $item->quantity,
                ];
            }),
        ];

        return Inertia::render('admin/orders/Show', [
            'order' => $orderData,
        ]);
    }

    /**
     * Update the order status
     */
    public function updateStatus(UpdateOrderStatusRequest $request, int $orderId, UpdateOrderStatusAction $action): RedirectResponse
    {
        try {
            $action->execute($orderId, $request->validated());

            return back()->with('success', 'Order status updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
