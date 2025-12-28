<?php

namespace App\Notifications\Client;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Order $order;
    public string $oldStatus;
    public string $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $emoji = match ($this->newStatus) {
            'processing' => '⚙️',
            'shipped' => '🚚',
            'delivered' => '✅',
            'cancelled' => '❌',
            default => '📦',
        };

        return new MailMessage()->subject("{$emoji} Order #{$this->order->id} - Status Update")->view('emails.client.order-status-changed', [
            'order' => $this->order,
            'oldStatus' => $this->oldStatus,
            'newStatus' => $this->newStatus,
        ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Your order #{$this->order->id} status changed to {$this->newStatus}",
        ];
    }

    /**
     * Get status-specific message
     */
    private function getStatusMessage(): string
    {
        return match ($this->newStatus) {
            'processing' => 'Great news! Your order is now being processed.',
            'shipped' => 'Your order has been shipped! It should arrive soon.',
            'delivered' => 'Your order has been delivered! We hope you enjoy your purchase.',
            'cancelled' => 'Your order has been cancelled. If you have any questions, please contact us.',
            default => "Your order status has been updated to {$this->newStatus}.",
        };
    }
}
