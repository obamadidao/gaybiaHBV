<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Mail\OrderConfirmationMail;
use App\Mail\OrderDeliveredMail;
use App\Mail\OrderCancelledMail;
use App\Mail\OrderRefundedMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SendOrderStatusEmail implements ShouldQueue
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
public function handle(OrderStatusChanged $event): void
{
try {
$order = $event->order;
$oldStatus = $event->oldStatus;
$newStatus = $event->newStatus;

            // Debug log để track listener execution  
            Log::info('SendOrderStatusEmail listener triggered', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'payment_status' => $order->payment_status,
                'payment_method' => $order->payment_method,
                'user_email' => $order->user->email ?? 'No email'
            ]);
            
            // NGĂN CHẶN DUPLICATE: Kiểm tra cache để tránh gửi email trùng lặp
            $cacheKey = "order_confirmation_email_sent_{$order->id}";
            if (Cache::has($cacheKey)) {
                Log::info('Order confirmation email already sent (cache check)', [
                    'order_id' => $order->id,
                    'cache_key' => $cacheKey
                ]);
                return;
            }
            
// Kiểm tra order có user và email không
if (!$order->user || !$order->user->email) {
Log::warning('Cannot send order status email: No user or email found', [
'order_id' => $order->id,
'order_number' => $order->order_number,
'status' => $newStatus
]);
return;
}

$emailSent = false;

// LOGIC MỚI: Kiểm tra xem có cần gửi email xác nhận đơn hàng không
// Trường hợp: Thanh toán online thành công (payment_status chuyển từ pending -> paid)
            if ($this->shouldSendConfirmationEmailOnPayment($order, $oldStatus, $newStatus)) {
            $shouldSendConfirmation = $this->shouldSendConfirmationEmailOnPayment($order, $oldStatus, $newStatus);
            
            Log::info('Checking if should send confirmation email', [
                'order_id' => $order->id,
                'should_send' => $shouldSendConfirmation,
                'payment_method' => $order->payment_method,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'payment_status' => $order->payment_status
            ]);
            
            if ($shouldSendConfirmation) {
Mail::to($order->user->email)
->send(new OrderConfirmationMail($order));

                // Đánh dấu đã gửi email confirmation để tránh duplicate
                Cache::put($cacheKey, true, now()->addHours(24));
                
Log::info('Order confirmation email sent after successful payment', [
'order_id' => $order->id,
'order_number' => $order->order_number,
'email' => $order->user->email,
'payment_method' => $order->payment_method,
'old_status' => $oldStatus,
                    'new_status' => $newStatus
                    'new_status' => $newStatus,
                    'cache_key' => $cacheKey
]);

$emailSent = true;
}

// Gửi email tương ứng với trạng thái mới
switch ($newStatus) {
case 'delivered':
Mail::to($order->user->email)
->send(new OrderDeliveredMail($order));
$emailSent = true;
break;

case 'cancelled':
Mail::to($order->user->email)
->send(new OrderCancelledMail($order));
$emailSent = true;
break;

case 'refunded':
Mail::to($order->user->email)
->send(new OrderRefundedMail($order));
$emailSent = true;
break;

default:
// Không gửi email cho các trạng thái khác (trừ confirmation ở trên)
if (!$emailSent) {
Log::info('No email configured for order status', [
'order_id' => $order->id,
'status' => $newStatus
]);
return;
}
}

if ($emailSent) {
Log::info('Order status email sent successfully', [
'order_id' => $order->id,
'order_number' => $order->order_number,
'email' => $order->user->email,
'status' => $newStatus
]);
}

} catch (\Exception $e) {
Log::error('Failed to send order status email', [
'order_id' => $event->order->id ?? null,
'status' => $event->newStatus ?? null,
'error' => $e->getMessage(),
'trace' => $e->getTraceAsString()
]);

// Không throw exception để không ảnh hưởng đến flow chính
}
}

/**
    * Kiểm tra xem có nên gửi email xác nhận khi thanh toán thành công không
    */
private function shouldSendConfirmationEmailOnPayment(Order $order, string $oldStatus, string $newStatus): bool
{
        // Log chi tiết các điều kiện
        $isOnlinePayment = in_array($order->payment_method, ['zalopay', 'vnpay', 'momo', 'online']);
        $isCorrectStatusTransition = $oldStatus === 'pending' && $newStatus === 'processing';
        $isPaid = $order->payment_status === 'paid';
        
        Log::info('Checking email confirmation conditions for online payment', [
            'order_id' => $order->id,
            'payment_method' => $order->payment_method,
            'is_online_payment' => $isOnlinePayment,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'is_correct_status_transition' => $isCorrectStatusTransition,
            'payment_status' => $order->payment_status,
            'is_paid' => $isPaid,
            'all_conditions_met' => $isOnlinePayment && $isCorrectStatusTransition && $isPaid
        ]);
        
// Chỉ gửi email xác nhận khi:
// 1. Là thanh toán online
// 2. Trạng thái chuyển từ pending -> processing (tức là vừa thanh toán thành công)
// 3. Payment status là paid
        return in_array($order->payment_method, ['zalopay', 'vnpay', 'momo', 'online']) &&
               $oldStatus === 'pending' &&
               $newStatus === 'processing' &&
               $order->payment_status === 'paid';
        return $isOnlinePayment && $isCorrectStatusTransition && $isPaid;
}
}