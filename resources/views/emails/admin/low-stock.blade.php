<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alert</title>
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
            background: linear-gradient(135deg, #dc2626 0%, #ea580c 100%);
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

        .alert-badge {
            display: inline-block;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
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

        .warning-box {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 4px solid #dc2626;
        }

        .warning-icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 15px;
        }

        .warning-title {
            font-size: 20px;
            font-weight: bold;
            color: #991b1b;
            text-align: center;
            margin-bottom: 15px;
        }

        .product-box {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .product-title {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .product-details:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .product-label {
            color: #6b7280;
            font-weight: 600;
        }

        .product-value {
            color: #1f2937;
            font-weight: bold;
        }

        .stock-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
        }

        .stock-bar {
            width: 100%;
            height: 30px;
            background-color: #e5e7eb;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .stock-fill {
            height: 100%;
            background: linear-gradient(90deg, #dc2626 0%, #ef4444 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: bold;
            font-size: 14px;
        }

        .action-box {
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .action-box p {
            margin: 0;
            color: #92400e;
            line-height: 1.6;
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
            <h1 class="header-title">⚠️ Low Stock Alert</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="alert-badge">🚨 Urgent: Low Stock</div>

            <h2 class="greeting">Inventory Alert!</h2>

            <p class="message">
                This is an urgent notification regarding low inventory levels. One of your products is running low on
                stock and requires immediate attention.
            </p>

            <!-- Warning Box -->
            <div class="warning-box">
                <div class="warning-icon">📦</div>
                <div class="warning-title">Stock Level Critical</div>
                <p style="text-align: center; color: #991b1b; margin: 0;">
                    This product has fallen below the minimum stock threshold and needs to be restocked as soon as
                    possible.
                </p>
            </div>

            <!-- Product Information -->
            <div class="product-box">
                <div class="product-title">📋 Product Details</div>

                <div class="product-details">
                    <span class="product-label">Product Name:</span>
                    <span class="product-value">{{ $product->name }}</span>
                </div>

                <div class="product-details">
                    <span class="product-label">Product ID:</span>
                    <span class="product-value">#{{ $product->id }}</span>
                </div>

                <div class="product-details">
                    <span class="product-label">Current Stock:</span>
                    <span class="product-value" style="color: #dc2626;">{{ $product->stock_quantity }} units</span>
                </div>

                <div class="product-details">
                    <span class="product-label">Price:</span>
                    <span class="product-value">${{ number_format($product->price, 2) }}</span>
                </div>

                <!-- Stock Indicator -->
                <div style="margin-top: 20px;">
                    <p style="color: #6b7280; font-size: 14px; margin-bottom: 10px;">Stock Level:</p>
                    <div class="stock-bar">
                        <div class="stock-fill" style="width: {{ min(($product->stock_quantity / 50) * 100, 100) }}%;">
                            {{ $product->stock_quantity }} / 50
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Required Box -->
            <div class="action-box">
                <p>
                    <strong>⏰ Action Required:</strong><br>
                    Please restock this product as soon as possible to avoid running out of inventory. Low stock levels
                    can lead to:
                </p>
                <ul style="margin: 10px 0; padding-left: 20px; color: #92400e;">
                    <li>Lost sales opportunities</li>
                    <li>Customer disappointment</li>
                    <li>Negative impact on revenue</li>
                </ul>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/admin/products') }}" class="button">
                    Manage Product Inventory →
                </a>
            </div>

            <div class="divider"></div>

            <p class="message" style="color: #6b7280; font-size: 14px;">
                <strong>Tip:</strong> Set up automatic reordering to prevent stock shortages in the future. Consider
                increasing your safety stock levels for popular items.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text"><strong>Shonen Street Admin</strong></p>
            <p class="footer-text">Inventory Management System</p>
            <p class="footer-text" style="margin-top: 15px;">
                © {{ date('Y') }} Shonen Street. All rights reserved.
            </p>
            <p class="footer-text" style="font-size: 12px; color: #9ca3af; margin-top: 15px;">
                This is an automated low stock alert for product #{{ $product->id }}.
            </p>
        </div>
    </div>
</body>

</html>
