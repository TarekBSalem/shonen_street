<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use App\Notifications\Admin\LowStockNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendLowStockNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Product $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all admin users
        $admins = User::where('is_admin', true)->get();

        // Send notification to each admin
        foreach ($admins as $admin) {
            $admin->notify(new LowStockNotification($this->product));
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        \Log::error('Failed to send low stock notification', [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'error' => $exception->getMessage(),
        ]);
    }
}
