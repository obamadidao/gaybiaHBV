<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo hủy đơn hàng</title>
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
            background: #dc3545;
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
            color: #dc3545;
            border-top: 2px solid #dc3545;
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
        .cancel-icon {
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .reason-section {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="cancel-icon">❌</div>
        <h1>Đơn hàng đã bị hủy</h1>
        <p>Thông báo về việc hủy đơn hàng của bạn</p>
    </div>

    <div class="content">
        <h2>Xin chào {{ $customer->name }}!</h2>
        
        <p>Chúng tôi xin thông báo rằng đơn hàng của bạn đã bị hủy.</p>

        <div class="order-info">
            <h3>Thông tin đơn hàng bị hủy</h3>
            <p><strong>Mã đơn hàng:</strong> {{ $order->order_number }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Ngày hủy:</strong> {{ $order->cancelled_at ? $order->cancelled_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</p>
            <p><strong>Trạng thái:</strong> <span style="color: #dc3545; font-weight: bold;">❌ Đã hủy</span></p>
        </div>

        @if($reason)
        <div class="reason-section">
            <h3 style="color: #721c24; margin-top: 0;">Lý do hủy đơn hàng:</h3>
            <p style="color: #721c24; margin: 0;">{{ $reason }}</p>
        </div>
        @endif

        <div class="order-info">
            <h3>Chi tiết đơn hàng đã hủy</h3>
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
                            <strong style="color: #dc3545; font-size: 14px;">{{ number_format($item->total_price) }}đ</strong>
                        </td>
                    </tr>
                </table>
            </div>
            @endforeach

            <div style="margin-top: 20px; border-top: 2px solid #dc3545; padding-top: 15px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="font-weight: bold; font-size: 16px; color: #dc3545;">Tổng giá trị đơn hàng đã hủy:</td>
                        <td style="text-align: right; font-weight: bold; font-size: 16px; color: #dc3545;">{{ number_format($order->total_amount) }}đ</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($order->payment_status === 'paid')
        <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
            <h4 style="margin-top: 0; color: #856404;">💳 Thông tin hoàn tiền:</h4>
            <ul style="margin: 0; padding-left: 20px; color: #856404;">
                <li>Đơn hàng của bạn đã được thanh toán</li>
                <li>Chúng tôi sẽ hoàn tiền trong vòng 3-5 ngày làm việc</li>
                <li>Tiền sẽ được hoàn về tài khoản/phương thức thanh toán ban đầu</li>
                <li>Bạn sẽ nhận được email xác nhận khi hoàn tiền thành công</li>
            </ul>
        </div>
        @endif

        <div style="margin-top: 30px; padding: 20px; background: #d1ecf1; border-radius: 8px; border-left: 4px solid #bee5eb;">
            <h4 style="margin-top: 0; color: #0c5460;">📞 Hỗ trợ khách hàng:</h4>
            <p style="color: #0c5460; margin: 0;">
                Nếu bạn có bất kỳ thắc mắc nào về việc hủy đơn hàng, 
                vui lòng liên hệ với chúng tôi:
            </p>
            <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #0c5460;">
                <li>Hotline: {{ config('app.phone', '0123456789') }}</li>
                <li>Email: {{ config('mail.from.address') }}</li>
                <li>Thời gian hỗ trợ: 8:00 - 22:00 hàng ngày</li>
            </ul>
        </div>

        <div style="margin-top: 30px; text-align: center; padding: 20px; background: #e2e3e5; border-radius: 8px;">
            <h4 style="margin-top: 0; color: #383d41;">🛍️ Tiếp tục mua sắm</h4>
            <p style="color: #383d41;">Chúng tôi hy vọng được phục vụ bạn trong những lần mua sắm tiếp theo!</p>
            <a href="{{ route('client.index') }}" style="background: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 10px;">
                Khám phá sản phẩm mới
            </a>
        </div>

        <div style="margin-top: 20px; text-align: center; font-style: italic; color: #6c757d;">
            <p>Chúng tôi xin lỗi vì sự bất tiện này và cảm ơn sự thông hiểu của bạn.</p>
        </div>
    </div>

    <div class="footer">
        <p><strong>{{ config('app.name') }}</strong></p>
        <p>🏪 Cửa hàng uy tín - Dịch vụ tận tâm</p>
        <p>📞 Hotline: {{ config('app.phone', '0123456789') }} | 📧 Email: {{ config('mail.from.address') }}</p>
        <p style="margin: 0; font-size: 0.8em; color: #adb5bd;">
            Email này được gửi tự động, vui lòng không trả lời email này.
        </p>
    </div>
</body>
</html>