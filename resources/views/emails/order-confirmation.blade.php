<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đặt hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border: 1px solid #dee2e6;
        }
        .order-info {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .item-row {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .total-row {
            font-weight: bold;
            font-size: 1.1em;
            color: #007bff;
            border-top: 2px solid #007bff;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer {
            background: #6c757d;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 0.9em;
        }
        .success-icon {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="success-icon">✅</div>
        <h1>Xác nhận đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã tin tưởng và mua hàng tại cửa hàng của chúng tôi</p>
    </div>

    <div class="content">
        <h2>Xin chào {{ $customer->name }}!</h2>
        
        <p>Chúng tôi đã nhận được đơn hàng của bạn và đang xử lý. Dưới đây là thông tin chi tiết:</p>

        <div class="order-info">
            <h3>Thông tin đơn hàng</h3>
            <p><strong>Mã đơn hàng:</strong> {{ $order->order_number }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : ucfirst($order->payment_method) }}</p>
            <p><strong>Trạng thái:</strong> <span style="color: #ffc107;">Chờ xử lý</span></p>
        </div>

        <div class="order-info">
            <h3>Thông tin giao hàng</h3>
            <p><strong>Người nhận:</strong> {{ $order->shipping_address['name'] ?? 'N/A' }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->shipping_address['phone'] ?? 'N/A' }}</p>
            <p><strong>Địa chỉ:</strong> 
                {{ $order->shipping_address['address'] ?? '' }}, 
                {{ $order->shipping_address['ward'] ?? '' }}, 
                {{ $order->shipping_address['city'] ?? '' }}
            </p>
        </div>

        <div class="order-info">
            <h3>Sản phẩm đã đặt</h3>
            @foreach($items as $item)
            <div style="padding: 8px 0; border-bottom: 1px solid #eee;">
                <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 40%; vertical-align: middle; padding: 5px 0;">
                            <strong style="font-size: 14px; color: #333;">{{ $item->product_name }}</strong>
                            @if($item->variant_name)
                                <span style="color: #6c757d; font-size: 12px;"> ({{ $item->variant_name }})</span>
                            @endif
                        </td>
                        <td style="width: 15%; text-align: center; vertical-align: middle; padding: 5px;">
                            <span style="font-size: 13px; color: #666;">SL: {{ $item->quantity }}</span>
                        </td>
                        <td style="width: 20%; text-align: right; vertical-align: middle; padding: 5px;">
                            <span style="font-size: 13px; color: #666;">{{ number_format($item->unit_price) }}đ</span>
                        </td>
                        <td style="width: 25%; text-align: right; vertical-align: middle; padding: 5px;">
                            <strong style="color: #007bff; font-size: 14px;">{{ number_format($item->total_price) }}đ</strong>
                        </td>
                    </tr>
                </table>
            </div>
            @endforeach

            <div style="margin-top: 20px; border-top: 1px solid #dee2e6; padding-top: 15px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 10px;">
                    <tr>
                        <td style="padding: 5px 0; color: #666;">Tạm tính:</td>
                        <td style="padding: 5px 0; text-align: right; color: #333;">{{ number_format($order->subtotal) }}đ</td>
                    </tr>
                    <tr>
                        <td style="padding: 5px 0; color: #666;">Phí vận chuyển:</td>
                        <td style="padding: 5px 0; text-align: right; color: #333;">{{ number_format($order->shipping_fee ?? 0) }}đ</td>
                    </tr>
                    @if($order->discount_amount > 0)
                    <tr>
                        <td style="padding: 5px 0; color: #28a745;">Giảm giá:</td>
                        <td style="padding: 5px 0; text-align: right; color: #28a745;">-{{ number_format($order->discount_amount) }}đ</td>
                    </tr>
                    @endif
                    <tr style="border-top: 2px solid #007bff;">
                        <td style="padding: 10px 0 0 0; font-weight: bold; font-size: 16px; color: #007bff;">Tổng cộng:</td>
                        <td style="padding: 10px 0 0 0; text-align: right; font-weight: bold; font-size: 16px; color: #007bff;">{{ number_format($order->total_amount) }}đ</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($order->notes)
        <div class="order-info">
            <h3>Ghi chú</h3>
            <p>{{ $order->notes }}</p>
        </div>
        @endif

        <div style="margin-top: 30px; padding: 20px; background: #e7f3ff; border-radius: 8px; border-left: 4px solid #007bff;">
            <h4 style="margin-top: 0; color: #007bff;">Thông tin quan trọng:</h4>
            <ul style="margin: 0; padding-left: 20px;">
                <li>Đơn hàng của bạn đang được xử lý và sẽ được giao trong 2-3 ngày làm việc</li>
                <li>Bạn sẽ nhận được email thông báo khi đơn hàng được giao</li>
                <li>Nếu có thắc mắc, vui lòng liên hệ: {{ config('app.phone', '0123456789') }}</li>
                <li>Email hỗ trợ: {{ config('mail.from.address') }}</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p><strong>{{ config('app.name') }}</strong></p>
        <p>Cảm ơn bạn đã mua hàng! Chúng tôi hy vọng bạn sẽ hài lòng với sản phẩm.</p>
        <p style="margin: 0; font-size: 0.8em; color: #adb5bd;">
            Email này được gửi tự động, vui lòng không trả lời email này.
        </p>
    </div>
</body>
</html>