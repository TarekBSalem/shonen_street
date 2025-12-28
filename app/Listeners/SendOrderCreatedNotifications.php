<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\Admin\NewOrderNotification;
use App\Notifications\Client\OrderConfirmedNotification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderCreatedNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;

        // Send notification to customer
        $order->user->notify(new OrderConfirmedNotification($order));

        // Send notification to all admins
        $admins = User::where('is_admin', true)->get();

        foreach ($admins as $admin) {
            $admin->notify(new NewOrderNotification($order));
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(OrderCreated $event, \Throwable $exception): void
    {
        \Log::error('Failed to send order created notifications', [
            'order_id' => $event->order->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
