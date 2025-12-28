<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DailySalesReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public array $reportData;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $reportData)
    {
        $this->reportData = $reportData;
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
        return (new MailMessage)
            ->subject("📊 Daily Sales Report - {$this->reportData['date']}")
            ->view('emails.admin.daily-sales-report', ['reportData' => $this->reportData]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'date' => $this->reportData['date'],
            'total_orders' => $this->reportData['total_orders'],
            'total_revenue' => $this->reportData['total_revenue'],
            'products_count' => count($this->reportData['products_sold']),
            'message' => "Daily sales report for {$this->reportData['date']}: {$this->reportData['total_orders']} orders, $" . number_format($this->reportData['total_revenue'], 2) . " revenue",
        ];
    }
}

