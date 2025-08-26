<?php

namespace App\Console\Commands;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class TestEmailConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email-config {email? : Email để test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test cấu hình email và queue system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔧 Kiểm tra cấu hình email và queue...');
        
        // Kiểm tra cấu hình email
        $this->info("\n📧 Cấu hình Email:");
        $this->line("- MAIL_MAILER: " . config('mail.default'));
        $this->line("- MAIL_HOST: " . config('mail.mailers.smtp.host'));
        $this->line("- MAIL_PORT: " . config('mail.mailers.smtp.port'));
        $this->line("- MAIL_FROM: " . config('mail.from.address'));
        
        // Kiểm tra queue
        $this->info("\n⚡ Cấu hình Queue:");
        $this->line("- QUEUE_CONNECTION: " . config('queue.default'));
        
        // Kiểm tra queue worker
        $this->info("\n👷 Queue Worker Status:");
        try {
            $size = Queue::size();
            $this->line("- Pending jobs: {$size}");
        } catch (\Exception $e) {
            $this->error("- Lỗi kết nối queue: " . $e->getMessage());
        }
        
        // Test email cơ bản
        $email = $this->argument('email') ?: $this->ask('Nhập email để test (enter để skip)');
        
        if ($email) {
            $this->info("\n📨 Test gửi email đến: {$email}");
            
            try {
                // Tìm đơn hàng để test
                $order = Order::with(['user', 'orderItems.product'])
                    ->latest()
                    ->first();
                    
                if (!$order) {
                    $this->error('Không tìm thấy đơn hàng nào để test');
                    return 1;
                }
                
                $this->line("Sử dụng đơn hàng: {$order->order_number}");
                
                // Test gửi email
                Mail::to($email)->send(new OrderConfirmationMail($order));
                
                $this->info('✅ Email đã được queue thành công!');
                $this->info('📋 Kiểm tra:');
                $this->line('1. Chạy queue worker: php artisan queue:work --once');
                $this->line('2. Xem log: storage/logs/laravel.log');
                $this->line('3. Kiểm tra hộp thư nhận');
                
            } catch (\Exception $e) {
                $this->error("❌ Lỗi gửi email: " . $e->getMessage());
                Log::error('Test email failed', [
                    'email' => $email,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // Hiển thị hướng dẫn debug
        $this->info("\n🔍 Debug Commands:");
        $this->line('- Test ZaloPay email: php artisan force:zalopay-email');
        $this->line('- Process queue: php artisan queue:work');
        $this->line('- Clear cache: php artisan config:clear');
        $this->line('- View logs: tail -f storage/logs/laravel.log');
        
        return 0;
    }
}