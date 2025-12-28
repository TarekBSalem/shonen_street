<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Notifications\Client\OrderStatusChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderStatusUpdatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order;

        // Send notification to customer
        $order->user->notify(new OrderStatusChangedNotification($order, $event->oldStatus, $event->newStatus));
    }

    /**
     * Handle a job failure.
     */
    public function failed(OrderStatusUpdated $event, \Throwable $exception): void
    {
        \Log::error('Failed to send order status updated notification', [
            'order_id' => $event->order->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
