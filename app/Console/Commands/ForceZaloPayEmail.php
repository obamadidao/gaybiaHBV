<?php

namespace App\Console\Commands;

use App\Events\OrderStatusChanged;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class ForceZaloPayEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'force:zalopay-email {order_id? : ID của đơn hàng ZaloPay}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force gửi email xác nhận cho đơn hàng ZaloPay đã thanh toán';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        if (!$orderId) {
            // Hiển thị danh sách đơn hàng ZaloPay để chọn
            $orders = Order::where('payment_method', 'zalopay')
                ->where('payment_status', 'paid')
                ->latest()
                ->take(10)
                ->get(['id', 'order_number', 'status', 'payment_status', 'created_at']);
                
            if ($orders->isEmpty()) {
                $this->error('Không tìm thấy đơn hàng ZaloPay nào đã thanh toán.');
                return 1;
            }
            
            $this->info('Danh sách đơn hàng ZaloPay đã thanh toán:');
            $this->table(
                ['ID', 'Mã đơn hàng', 'Trạng thái', 'Thanh toán', 'Ngày tạo'],
                $orders->map(function($order) {
                    return [
                        $order->id,
                        $order->order_number,
                        $order->status,
                        $order->payment_status,
                        $order->created_at->format('d/m/Y H:i')
                    ];
                })
            );
            
            $orderId = $this->ask('Nhập ID đơn hàng muốn gửi email');
        }
        
        $order = Order::with(['user', 'customer.user'])->find($orderId);
        
        if (!$order) {
            $this->error("Không tìm thấy đơn hàng với ID: {$orderId}");
            return 1;
        }

        $this->info("Thông tin đơn hàng:");
        $this->line("- ID: {$order->id}");
        $this->line("- Mã: {$order->order_number}");
        $this->line("- Payment method: {$order->payment_method}");
        $this->line("- Payment status: {$order->payment_status}");
        $this->line("- Order status: {$order->status}");
        $this->line("- User email: " . ($order->user->email ?? 'Không có email'));

        if (!$order->user || !$order->user->email) {
            $this->error('Đơn hàng không có thông tin user hoặc email.');
            return 1;
        }

        if ($order->payment_method !== 'zalopay') {
            $this->warn('Đơn hàng này không phải ZaloPay. Bạn có muốn tiếp tục? (y/N)');
            if (!$this->confirm('Tiếp tục?', false)) {
                return 0;
            }
        }

        $this->info("\n--- OPTION 1: Trigger Event (giống như callback thực tế) ---");
        if ($this->confirm('Bạn có muốn trigger OrderStatusChanged event?', true)) {
            try {
                // Clear cache trước khi test để tránh duplicate prevention
                $cacheKey = "order_confirmation_email_sent_{$order->id}";
                Cache::forget($cacheKey);
                $this->line("🧹 Cleared email cache: {$cacheKey}");
                
                Log::info('Manual trigger: OrderStatusChanged event', [
                    'order_id' => $order->id,
                    'command' => 'force:zalopay-email',
                    'cache_cleared' => true
                ]);
                
                event(new OrderStatusChanged($order, 'pending', 'processing'));
                $this->info('✅ Event đã được trigger!');
                
            } catch (\Exception $e) {
                $this->error("❌ Lỗi khi trigger event: " . $e->getMessage());
            }
        }

        $this->info("\n--- OPTION 2: Gửi email trực tiếp ---");
        if ($this->confirm('Bạn có muốn gửi email trực tiếp?', false)) {
            try {
                Mail::to($order->user->email)
                    ->send(new OrderConfirmationMail($order));
                    
                $this->info('✅ Email đã được gửi trực tiếp!');
                
                Log::info('Manual email sent for ZaloPay order', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'email' => $order->user->email,
                    'command' => 'force:zalopay-email'
                ]);
                
            } catch (\Exception $e) {
                $this->error("❌ Lỗi khi gửi email: " . $e->getMessage());
            }
        }

        $this->info("\n📋 Kiểm tra kết quả:");
        $this->line("- Xem log: storage/logs/laravel.log");
        $this->line("- Kiểm tra queue: php artisan queue:work --once");
        $this->line("- Test email: kiểm tra hộp thư nhận");

        return 0;
    }
}