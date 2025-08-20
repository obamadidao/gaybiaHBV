<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng đã được giao</title>
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
            background: #28a745;
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
            color: #28a745;
            border-top: 2px solid #28a745;
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
        .rating-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="success-icon">🎉</div>
        <h1>Đơn hàng đã được giao thành công!</h1>
        <p>Cảm ơn bạn đã tin tưởng mua hàng tại cửa hàng của chúng tôi</p>
    </div>

    <div class="content">
        <h2>Xin chào {{ $customer->name }}!</h2>
        
        <p>Chúng tôi rất vui thông báo rằng đơn hàng của bạn đã được giao thành công!</p>

        <div class="order-info">
            <h3>Thông tin đơn hàng</h3>
            <p><strong>Mã đơn hàng:</strong> {{ $order->order_number }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Ngày giao:</strong> {{ $order->delivered_at ? $order->delivered_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</p>
            <p><strong>Trạng thái:</strong> <span style="color: #28a745; font-weight: bold;">✅ Đã giao thành công</span></p>
        </div>

        <div class="order-info">
            <h3>Thông tin người nhận</h3>
            <p><strong>Người nhận:</strong> {{ $order->shipping_address['name'] ?? 'N/A' }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->shipping_address['phone'] ?? 'N/A' }}</p>
            <p><strong>Địa chỉ giao hàng:</strong> 
                {{ $order->shipping_address['address'] ?? '' }}, 
                {{ $order->shipping_address['ward'] ?? '' }}, 
                {{ $order->shipping_address['city'] ?? '' }}
            </p>
        </div>

        <div class="order-info">
            <h3>Sản phẩm đã giao</h3>
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
                            <strong style="color: #28a745; font-size: 14px;">{{ number_format($item->total_price) }}đ</strong>
                        </td>
                    </tr>
                </table>
            </div>
            @endforeach

            <div style="margin-top: 20px; border-top: 2px solid #28a745; padding-top: 15px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="font-weight: bold; font-size: 16px; color: #28a745;">Tổng giá trị đơn hàng:</td>
                        <td style="text-align: right; font-weight: bold; font-size: 16px; color: #28a745;">{{ number_format($order->total_amount) }}đ</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="rating-section">
            <h3 style="color: #856404; margin-top: 0;">⭐ Đánh giá sản phẩm</h3>
            <p>Bạn có hài lòng với sản phẩm và dịch vụ của chúng tôi không?</p>
            <p>Hãy chia sẻ trải nghiệm của bạn để giúp chúng tôi cải thiện dịch vụ!</p>
            <div style="margin: 15px 0;">
                <a href="{{ route('client.index') }}" style="background: #ffc107; color: #212529; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Đánh giá ngay
                </a>
            </div>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #d4edda; border-radius: 8px; border-left: 4px solid #28a745;">
            <h4 style="margin-top: 0; color: #155724;">Chính sách hậu mãi:</h4>
            <ul style="margin: 0; padding-left: 20px; color: #155724;">
                <li>Bảo hành sản phẩm theo chính sách của nhà sản xuất</li>
                <li>Đổi trả trong vòng 7 ngày nếu có lỗi từ nhà sản xuất</li>
                <li>Hỗ trợ kỹ thuật miễn phí trong suốt thời gian sử dụng</li>
                <li>Liên hệ: {{ config('app.phone', '0123456789') }} để được hỗ trợ</li>
            </ul>
        </div>

        <div style="margin-top: 20px; text-align: center; font-style: italic; color: #6c757d;">
            <p>"Cảm ơn bạn đã là khách hàng thân thiết của chúng tôi!"</p>
            <p>Chúng tôi hy vọng được phục vụ bạn trong những lần mua sắm tiếp theo.</p>
        </div>
    </div>

    <div class="footer">
        <p><strong>{{ config('app.name') }}</strong></p>
        <p>🏪 Cửa hàng uy tín - Chất lượng đảm bảo</p>
        <p>📞 Hotline: {{ config('app.phone', '0123456789') }} | 📧 Email: {{ config('mail.from.address') }}</p>
        <p style="margin: 0; font-size: 0.8em; color: #adb5bd;">
            Email này được gửi tự động, vui lòng không trả lời email này.
        </p>
    </div>
</body>
</html>