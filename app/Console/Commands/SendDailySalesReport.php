<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use App\Notifications\Admin\DailySalesReportNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendDailySalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily sales report to admin users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Generating daily sales report...');

        // Get today's date range
        $today = now()->startOfDay();
        $endOfDay = now()->endOfDay();

        // Get all orders created today
        $orders = Order::with(['items.product', 'user'])
            ->whereBetween('created_at', [$today, $endOfDay])
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No sales today. Skipping report.');
            return self::SUCCESS;
        }

        // Calculate sales statistics
        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total_price');
        
        // Get products sold with quantities
        $productsSold = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$today, $endOfDay])
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.price_at_purchase * order_items.quantity) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->get();

        $reportData = [
            'date' => $today->format('F d, Y'),
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'products_sold' => $productsSold,
        ];

        // Get all admin users
        $admins = User::where('is_admin', true)->get();

        if ($admins->isEmpty()) {
            $this->error('No admin users found to send report to.');
            return self::FAILURE;
        }

        // Send notification to each admin
        foreach ($admins as $admin) {
            $admin->notify(new DailySalesReportNotification($reportData));
            $this->info("Report sent to: {$admin->email}");
        }

        $this->info('Daily sales report sent successfully!');
        
        return self::SUCCESS;
    }
}
