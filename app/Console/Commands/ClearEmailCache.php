<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearEmailCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:email-cache {order_id? : ID đơn hàng cụ thể để clear cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cache email confirmation để test lại việc gửi email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('order_id');
        
        if ($orderId) {
            // Clear cache cho order cụ thể
            $cacheKey = "order_confirmation_email_sent_{$orderId}";
            Cache::forget($cacheKey);
            
            $this->info("✅ Đã clear cache email cho đơn hàng ID: {$orderId}");
            $this->line("Cache key: {$cacheKey}");
            
        } else {
            // Clear tất cả cache email confirmation
            $this->info("🧹 Clearing tất cả cache email confirmation...");
            
            // Không có cách nào để clear theo pattern nên chỉ có thể clear all cache
            $this->warn("⚠️  Lưu ý: Sẽ clear toàn bộ cache của application");
            
            if ($this->confirm('Bạn có chắc chắn muốn clear toàn bộ cache?', false)) {
                Cache::flush();
                $this->info("✅ Đã clear toàn bộ cache");
            } else {
                $this->info("ℹ️  Hủy bỏ. Sử dụng order_id cụ thể để clear cache cho từng đơn hàng.");
                $this->line("Ví dụ: php artisan clear:email-cache 123");
            }
        }
        
        $this->info("\n📋 Bây giờ bạn có thể test lại:");
        $this->line("- php artisan force:zalopay-email {$orderId}");
        $this->line("- php artisan test:zalopay-email {$orderId}");
        
        return 0;
    }
}