<?php

namespace App\Actions\Order;

use App\Events\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class UpdateOrderStatusAction
{
    /**
     * Update order status
     *
     * @param int $orderId
     * @param array $data
     * @return Order
     * @throws \Exception
     */
    public function execute(int $orderId, array $data): Order
    {
        return DB::transaction(function () use ($orderId, $data) {
            $order = Order::with('user')->findOrFail($orderId);

            $oldStatus = $order->status;
            $newStatus = $data['status'];

            // Validate status transition
            $this->validateStatusTransition($oldStatus, $newStatus);

            // Update status
            $order->update([
                'status' => $newStatus,
            ]);

            // Dispatch event
            event(new OrderStatusUpdated($order, $oldStatus, $newStatus));

            return $order->fresh();
        });
    }

    /**
     * Validate status transition rules
     *
     * @param string $oldStatus
     * @param string $newStatus
     * @throws \Exception
     */
    private function validateStatusTransition(string $oldStatus, string $newStatus): void
    {
        // Don't allow changing if status is the same
        if ($oldStatus === $newStatus) {
            throw new \Exception('Order already has this status');
        }

        // Cannot change status of cancelled orders
        if ($oldStatus === 'cancelled') {
            throw new \Exception('Cannot change status of cancelled orders');
        }

        // Cannot change status of delivered orders
        if ($oldStatus === 'delivered') {
            throw new \Exception('Cannot change status of delivered orders');
        }

        // All other transitions are allowed for flexibility
        // Admin can update to any status as needed
    }
}
