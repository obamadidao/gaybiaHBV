<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use App\Mail\OrderConfirmationMail;
use App\Mail\OrderDeliveredMail;
use App\Mail\OrderCancelledMail;
use App\Mail\OrderRefundedMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {type} {--email=} {--order-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email system: confirmation|delivered|cancelled|refunded';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->argument('type');
        $email = $this->option('email') ?: config('mail.from.address');
        $orderId = $this->option('order-id');

        if (!in_array($type, ['confirmation', 'delivered', 'cancelled', 'refunded'])) {
            $this->error('Invalid email type. Use: confirmation|delivered|cancelled|refunded');
            return 1;
        }

        // Tìm đơn hàng để test
        $order = null;
        if ($orderId) {
            $order = Order::with(['user', 'orderItems'])->find($orderId);
            if (!$order) {
                $this->error("Order not found with ID: {$orderId}");
                return 1;
            }
        } else {
            // Lấy đơn hàng đầu tiên có sẵn
            $order = Order::with(['user', 'orderItems'])->first();
            if (!$order) {
                $this->error('No orders found in database. Please create an order first.');
                return 1;
            }
        }

        $this->info("Testing {$type} email...");
        $this->info("Order: {$order->order_number}");
        $this->info("Email: {$email}");
        $this->line('');

        try {
            switch ($type) {
                case 'confirmation':
                    Mail::to($email)->send(new OrderConfirmationMail($order));
                    $this->info('✅ Order confirmation email sent successfully!');
                    break;

                case 'delivered':
                    Mail::to($email)->send(new OrderDeliveredMail($order));
                    $this->info('✅ Order delivered email sent successfully!');
                    break;

                case 'cancelled':
                    Mail::to($email)->send(new OrderCancelledMail($order, 'Test cancellation reason'));
                    $this->info('✅ Order cancelled email sent successfully!');
                    break;

                case 'refunded':
                    $refundAmount = $order->total_amount;
                    Mail::to($email)->send(new OrderRefundedMail($order, $refundAmount, 'Test refund reason'));
                    $this->info('✅ Order refunded email sent successfully!');
                    break;
            }

            $this->line('');
            $this->comment('Check your email inbox or logs for the test email.');
            $this->comment('If using MAIL_MAILER=log, check storage/logs/laravel.log');

        } catch (\Exception $e) {
            $this->error('❌ Failed to send email: ' . $e->getMessage());
            $this->line('');
            $this->comment('Possible issues:');
            $this->comment('1. SMTP configuration incorrect');
            $this->comment('2. Queue worker not running');
            $this->comment('3. Email address invalid');
            return 1;
        }

        return 0;
    }
}