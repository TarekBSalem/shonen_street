@component('mail::message')
    {{-- Header with Logo --}}
    <div style="text-align: center; margin-bottom: 40px;">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td align="center">
                    <div
                        style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); margin-bottom: 20px;">
                        <img src="{{ asset('assets/logos/logo_header.png') }}" alt="Shonen Street"
                            style="max-width: 250px; width: 100%; height: auto; display: block; object-fit: contain;" />
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Header Banner --}}
    <div
        style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; padding: 20px; margin-bottom: 30px; text-align: center;">
        <h1 style="color: white; margin: 0; font-size: 28px; font-weight: bold;">
            📊 Daily Sales Report
        </h1>
        <p style="color: white; margin: 10px 0 0 0; font-size: 16px; opacity: 0.95;">
            {{ $reportData['date'] }}
        </p>
    </div>

    {{-- Greeting --}}
    # Hello Admin!

    Here's your comprehensive sales report for today. Great work!

    {{-- Summary Cards --}}
    <table style="width: 100%; border-collapse: collapse; margin: 30px 0;">
        <tr>
            <td style="width: 50%; padding-right: 10px;">
                <div
                    style="background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%); border-radius: 12px; padding: 20px; text-align: center; border: 2px solid #667eea;">
                    <p style="color: #6c757d; font-size: 14px; margin: 0 0 5px 0; font-weight: 600;">Total Orders</p>
                    <p style="color: #667eea; font-size: 36px; font-weight: bold; margin: 0;">
                        {{ $reportData['total_orders'] }}</p>
                </div>
            </td>
            <td style="width: 50%; padding-left: 10px;">
                <div
                    style="background: linear-gradient(135deg, #28a74515 0%, #20c99715 100%); border-radius: 12px; padding: 20px; text-align: center; border: 2px solid #28a745;">
                    <p style="color: #6c757d; font-size: 14px; margin: 0 0 5px 0; font-weight: 600;">Total Revenue</p>
                    <p style="color: #28a745; font-size: 36px; font-weight: bold; margin: 0;">
                        ${{ number_format($reportData['total_revenue'], 2) }}</p>
                </div>
            </td>
        </tr>
    </table>

    {{-- Products Sold Section --}}
    <div style="background-color: #f8f9fa; border-radius: 12px; padding: 25px; margin: 25px 0;">
        <h3 style="margin-top: 0; color: #495057; font-size: 20px;">🏆 Top Products Sold Today</h3>

        @if (count($reportData['products_sold']) > 0)
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <thead>
                    <tr style="border-bottom: 2px solid #dee2e6;">
                        <th style="padding: 12px 0; color: #6c757d; font-weight: 600; text-align: left;">Product</th>
                        <th style="padding: 12px 0; color: #6c757d; font-weight: 600; text-align: center;">Units</th>
                        <th style="padding: 12px 0; color: #6c757d; font-weight: 600; text-align: right;">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportData['products_sold'] as $index => $product)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 12px 0; color: #212529;">
                                <span
                                    style="display: inline-block; background: #667eea; color: white; width: 24px; height: 24px; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; margin-right: 8px;">{{ $index + 1 }}</span>
                                {{ $product->name }}
                            </td>
                            <td style="padding: 12px 0; color: #495057; text-align: center; font-weight: bold;">
                                {{ $product->total_quantity }}</td>
                            <td style="padding: 12px 0; color: #28a745; text-align: right; font-weight: bold;">
                                ${{ number_format($product->total_revenue, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #6c757d; padding: 20px 0;">No products sold today.</p>
        @endif
    </div>

    {{-- Performance Indicator --}}
    <div
        style="background: linear-gradient(135deg, #f093fb15 0%, #f5576c15 100%); border-left: 4px solid #f5576c; padding: 20px; margin: 25px 0; border-radius: 8px;">
        <h4 style="margin-top: 0; color: #c92a2a; font-size: 16px;">📈 Performance Insights</h4>
        <p style="margin: 0; color: #495057; font-size: 14px; line-height: 1.6;">
            @if ($reportData['total_orders'] > 10)
                <strong style="color: #28a745;">🎉 Excellent!</strong> You had a great sales day with
                {{ $reportData['total_orders'] }} orders!
            @elseif($reportData['total_orders'] > 5)
                <strong style="color: #667eea;">👍 Good!</strong> Solid performance with {{ $reportData['total_orders'] }}
                orders today.
            @else
                <strong style="color: #ffc107;">💪 Keep going!</strong> {{ $reportData['total_orders'] }} orders today.
                Tomorrow is a new opportunity!
            @endif
        </p>
    </div>

    {{-- Action Button --}}
    @component('mail::button', ['url' => url('/admin/dashboard'), 'color' => 'primary'])
        View Full Dashboard
    @endcomponent

    {{-- Footer Message --}}
    <div style="text-align: center; margin-top: 40px; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
        <p style="color: #495057; font-size: 14px; margin: 0 0 5px 0;">
            Keep up the great work! 🚀
        </p>
        <p style="color: #6c757d; font-size: 12px; margin: 0;">
            This report is automatically generated daily at 6:00 PM
        </p>
    </div>

    {{-- Footer --}}
    <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 2px solid #e9ecef;">
        <p style="color: #6c757d; font-size: 13px; margin-bottom: 5px;">
            Thank you for managing Shonen Street!
        </p>
        <p style="color: #adb5bd; font-size: 12px; margin: 0;">
            © {{ date('Y') }} Shonen Street. All rights reserved.
        </p>
    </div>
@endcomponent
