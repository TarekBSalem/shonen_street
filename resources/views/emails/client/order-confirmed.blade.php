<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
        .success-badge {
            display: inline-block;
            background-color: #10b981;
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
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
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f3f4f6;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        .items-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #e5e7eb;
            color: #4b5563;
        }
        .product-name {
            font-weight: 600;
            color: #1f2937;
        }
        .total-row {
            background-color: #fef3c7;
            font-weight: bold;
        }
        .total-row td {
            padding: 20px 12px;
            font-size: 18px;
            color: #92400e;
        }
        .shipping-box {
            background-color: #f9fafb;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .shipping-title {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
        }
        .shipping-details {
            color: #4b5563;
            line-height: 1.8;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #dc2626 0%, #ea580c 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            margin: 20px 0;
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
            <h1 class="header-title">Order Confirmed! 🎉</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="success-badge">✓ Order Placed Successfully</div>
            
            <h2 class="greeting">Thank You for Your Order!</h2>
            
            <p class="message">
                We're excited to let you know that your order has been confirmed and is being prepared for shipment. 
                You'll receive another email when your order ships.
            </p>

            <!-- Order Summary Box -->
            <div class="order-box">
                <div class="order-number">Order #{{ $order->id }}</div>
                <div class="order-details">
                    <span class="order-label">Order Date:</span>
                    <span class="order-value">{{ $order->created_at->format('F d, Y') }}</span>
                </div>
                <div class="order-details">
                    <span class="order-label">Status:</span>
                    <span class="order-value">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="order-details">
                    <span class="order-label">Total Items:</span>
                    <span class="order-value">{{ $order->items->sum('quantity') }}</span>
                </div>
            </div>

            <!-- Order Items -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align: center;">Quantity</th>
                        <th style="text-align: right;">Price</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td class="product-name">{{ $item->product->name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">${{ number_format($item->price_at_purchase, 2) }}</td>
                        <td style="text-align: right;">${{ number_format($item->price_at_purchase * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Total Amount:</td>
                        <td style="text-align: right;">${{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Shipping Information -->
            <div class="shipping-box">
                <div class="shipping-title">📦 Shipping Information</div>
                <div class="shipping-details">
                    @php
                        $shipping = is_string($order->shipping_address) 
                            ? json_decode($order->shipping_address, true) 
                            : $order->shipping_address;
                    @endphp
                    <strong>{{ $shipping['name'] ?? 'N/A' }}</strong><br>
                    {{ $shipping['address'] ?? 'N/A' }}<br>
                    {{ $shipping['city'] ?? 'N/A' }}, {{ $shipping['state'] ?? 'N/A' }} {{ $shipping['zip'] ?? 'N/A' }}<br>
                    {{ $shipping['country'] ?? 'N/A' }}<br>
                    <br>
                    <strong>Phone:</strong> {{ $shipping['phone'] ?? 'N/A' }}<br>
                    <strong>Email:</strong> {{ $shipping['email'] ?? 'N/A' }}
                </div>
            </div>

            <div class="divider"></div>

            <p class="message">
                <strong>What's Next?</strong><br>
                We're processing your order and will send you a shipping confirmation email with tracking information once your package is on its way.
            </p>

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
                This email was sent to {{ $order->user->email }} regarding your order.
            </p>
        </div>
    </div>
</body>
</html>
