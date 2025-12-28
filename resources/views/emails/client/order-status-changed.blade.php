<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f7fafc;
            color: #2d3748;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #ea580c 50%, #facc15 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 20px;
        }
        .header-title {
            color: #ffffff;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .content {
            padding: 40px 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-shipped {
            background-color: #e0e7ff;
            color: #4338ca;
        }
        .status-delivered {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .greeting {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
        }
        .message {
            font-size: 16px;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .status-timeline {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .timeline-icon-old {
            background-color: #d1d5db;
            color: #6b7280;
        }
        .timeline-icon-new {
            background: linear-gradient(135deg, #dc2626 0%, #ea580c 100%);
            color: #ffffff;
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.3);
        }
        .timeline-content {
            flex: 1;
        }
        .timeline-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .timeline-status {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
        }
        .arrow {
            font-size: 24px;
            color: #9ca3af;
            margin: 0 15px;
        }
        .order-box {
            background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid #f59e0b;
        }
        .order-number {
            font-size: 18px;
            font-weight: bold;
            color: #92400e;
            margin-bottom: 10px;
        }
        .order-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .order-label {
            color: #78350f;
            font-weight: 600;
        }
        .order-value {
            color: #92400e;
            font-weight: bold;
        }
        .info-box {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .info-box p {
            margin: 0;
            color: #1e40af;
            line-height: 1.6;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
            margin: 5px 0;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('assets/logos/logo_header.png') }}" alt="Shonen Street" class="logo">
            <h1 class="header-title">Order Status Update</h1>
        </div>

        <!-- Content -->
        <div class="content">
            @php
                $statusEmojis = [
                    'pending' => '⏳',
                    'processing' => '📦',
                    'shipped' => '🚚',
                    'delivered' => '✅',
                    'cancelled' => '❌',
                ];
                $emoji = $statusEmojis[$newStatus] ?? '📋';
            @endphp
            
            <div class="status-badge status-{{ $newStatus }}">
                {{ $emoji }} {{ ucfirst($newStatus) }}
            </div>
            
            <h2 class="greeting">Your Order Status Has Been Updated!</h2>
            
            <p class="message">
                We wanted to let you know that your order status has changed. Here's the latest update on your order.
            </p>

            <!-- Order Summary Box -->
            <div class="order-box">
                <div class="order-number">Order #{{ $order->id }}</div>
                <div class="order-details">
                    <span class="order-label">Order Date:</span>
                    <span class="order-value">{{ $order->created_at->format('F d, Y') }}</span>
                </div>
                <div class="order-details">
                    <span class="order-label">Total Amount:</span>
                    <span class="order-value">${{ number_format($order->total_price, 2) }}</span>
                </div>
                <div class="order-details">
                    <span class="order-label">Items:</span>
                    <span class="order-value">{{ $order->items->sum('quantity') }} item(s)</span>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="status-timeline">
                <div style="display: flex; align-items: center; justify-content: center;">
                    <div style="text-align: center;">
                        <div class="timeline-icon timeline-icon-old">
                            {{ $statusEmojis[$oldStatus] ?? '📋' }}
                        </div>
                        <div class="timeline-label">Previous Status</div>
                        <div class="timeline-status">{{ ucfirst($oldStatus) }}</div>
                    </div>
                    
                    <div class="arrow">→</div>
                    
                    <div style="text-align: center;">
                        <div class="timeline-icon timeline-icon-new">
                            {{ $statusEmojis[$newStatus] ?? '📋' }}
                        </div>
                        <div class="timeline-label">Current Status</div>
                        <div class="timeline-status">{{ ucfirst($newStatus) }}</div>
                    </div>
                </div>
            </div>

            <!-- Status-specific messages -->
            @if($newStatus === 'processing')
            <div class="info-box">
                <p>
                    <strong>📦 Your order is being processed!</strong><br>
                    Our team is carefully preparing your items for shipment. You'll receive another email with tracking information once your package ships.
                </p>
            </div>
            @elseif($newStatus === 'shipped')
            <div class="info-box">
                <p>
                    <strong>🚚 Your order has shipped!</strong><br>
                    Your package is on its way! You should receive it within 3-5 business days. Keep an eye on your email for tracking updates.
                </p>
            </div>
            @elseif($newStatus === 'delivered')
            <div class="info-box" style="background-color: #f0fdf4; border-color: #22c55e;">
                <p style="color: #166534;">
                    <strong>✅ Your order has been delivered!</strong><br>
                    We hope you love your new manga! If you have any issues with your order, please don't hesitate to contact us.
                </p>
            </div>
            @elseif($newStatus === 'cancelled')
            <div class="info-box" style="background-color: #fef2f2; border-color: #ef4444;">
                <p style="color: #991b1b;">
                    <strong>❌ Your order has been cancelled.</strong><br>
                    If you didn't request this cancellation or have any questions, please contact our support team immediately.
                </p>
            </div>
            @endif

            <div class="divider"></div>

            <p class="message">
                <strong>Order Items:</strong>
            </p>
            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #e5e7eb;">
                    <td style="padding: 12px 0; color: #1f2937; font-weight: 600;">
                        {{ $item->product->name }}
                    </td>
                    <td style="padding: 12px 0; text-align: center; color: #6b7280;">
                        × {{ $item->quantity }}
                    </td>
                    <td style="padding: 12px 0; text-align: right; color: #1f2937; font-weight: 600;">
                        ${{ number_format($item->price_at_purchase * $item->quantity, 2) }}
                    </td>
                </tr>
                @endforeach
            </table>

            <p class="message" style="color: #6b7280; font-size: 14px;">
                If you have any questions about your order, please don't hesitate to contact us. We're here to help!
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text"><strong>Shonen Street</strong></p>
            <p class="footer-text">Your Ultimate Manga Destination</p>
            <p class="footer-text" style="margin-top: 15px;">
                © {{ date('Y') }} Shonen Street. All rights reserved.
            </p>
            <p class="footer-text" style="font-size: 12px; color: #9ca3af; margin-top: 15px;">
                This email was sent to {{ $order->user->email }} regarding order #{{ $order->id }}.
            </p>
        </div>
    </div>
</body>
</html>
