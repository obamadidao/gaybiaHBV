<?php

namespace App\Listeners;

use App\Events\NewOrderCreated;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendOrderConfirmationEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewOrderCreated $event): void
    {
        try {
            $order = $event->order;
            
            // Kiểm tra order có user và email không
            if (!$order->user || !$order->user->email) {
                Log::warning('Cannot send order confirmation email: No user or email found', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
                return;
            }

            // LOGIC MỚI: Chỉ gửi email theo logic thanh toán
            $shouldSendEmail = $this->shouldSendConfirmationEmail($order);
            
            if (!$shouldSendEmail) {
                Log::info('Order confirmation email skipped - waiting for payment completion', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_method' => $order->payment_method,
                    'payment_status' => $order->payment_status
                ]);
                return;
            }

            // Gửi email xác nhận đặt hàng
            Mail::to($order->user->email)
                ->send(new OrderConfirmationMail($order));

            Log::info('Order confirmation email sent successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'email' => $order->user->email,
                'payment_method' => $order->payment_method
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email', [
                'order_id' => $event->order->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Không throw exception để không ảnh hưởng đến flow chính
        }
    }

    /**
     * Xác định có nên gửi email xác nhận hay không
     */
    private function shouldSendConfirmationEmail(Order $order): bool
    {
        // COD: Gửi email ngay khi tạo đơn hàng
        if ($order->payment_method === 'cod') {
            return true;
        }

        // Online Payment: Chỉ gửi email khi đã thanh toán thành công
        if (in_array($order->payment_method, ['zalopay', 'vnpay', 'momo', 'online'])) {
            return $order->payment_status === 'paid';
        }

        // Các phương thức khác: Default gửi email
        return true;
    }
}