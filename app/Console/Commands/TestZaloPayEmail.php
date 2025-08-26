<?php

namespace App\Console\Commands;

use App\Events\OrderStatusChanged;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestZaloPayEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:zalopay-email {order_id? : ID của đơn hàng ZaloPay để test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test gửi email xác nhận cho đơn hàng ZaloPay';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        if (!$orderId) {
            // Tìm đơn hàng ZaloPay gần nhất
            $order = Order::where('payment_method', 'zalopay')
                ->where('payment_status', 'paid')
                ->where('status', 'processing')
                ->latest()
                ->first();
                
            if (!$order) {
                $this->error('Không tìm thấy đơn hàng ZaloPay nào để test. Vui lòng cung cấp order_id.');
                return 1;
            }
        } else {
            $order = Order::find($orderId);
            if (!$order) {
                $this->error("Không tìm thấy đơn hàng với ID: {$orderId}");
                return 1;
            }
        }

        $this->info("Testing email cho đơn hàng: {$order->order_number}");
        $this->info("Payment method: {$order->payment_method}");
        $this->info("Payment status: {$order->payment_status}");
        $this->info("Order status: {$order->status}");
        $this->info("User email: " . ($order->user->email ?? 'Không có email'));

        if (!$order->user || !$order->user->email) {
            $this->error('Đơn hàng không có thông tin user hoặc email.');
            return 1;
        }

        // Load relationships
        $order->load(['user', 'customer.user']);

        $this->info("\nTriggering OrderStatusChanged event...");
        
        // Log trước khi trigger event
        Log::info('Manual test: About to trigger OrderStatusChanged event', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'test_mode' => true
        ]);

        try {
            // Trigger event giống như trong ZaloPay callback
            event(new OrderStatusChanged($order, 'pending', 'processing'));
            
            $this->info('✅ Event đã được trigger thành công!');
            $this->info('📧 Kiểm tra log để xem listener có được gọi không.');
            $this->info('📂 Log file: storage/logs/laravel.log');
            $this->line('');
            $this->info('🔍 Tìm kiếm các log entries sau:');
            $this->line('- "SendOrderStatusEmail listener triggered"');
            $this->line('- "Checking if should send confirmation email"');
            $this->line('- "Order confirmation email sent after successful payment"');
            
        } catch (\Exception $e) {
            $this->error("❌ Lỗi khi trigger event: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}