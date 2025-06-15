<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy users và products để tạo đơn hàng
        $users = User::all();
        $products = Product::with('variants')->get();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Cần có users và products trước khi tạo orders. Chạy UserSeeder và ProductSeeder trước.');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed'];
        $paymentMethods = ['cod', 'bank_transfer', 'momo', 'vnpay'];
        $shippingMethods = ['standard', 'express', 'same_day'];

        // Tạo 50 đơn hàng mẫu
        for ($i = 1; $i <= 50; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $paymentStatuses[array_rand($paymentStatuses)];
            
            // Tạo địa chỉ mẫu
            $shippingAddress = [
                'name' => $user->name,
                'phone' => '0' . rand(100000000, 999999999),
                'address' => 'Số ' . rand(1, 999) . ' đường ' . ['Nguyễn Trãi', 'Lê Lợi', 'Trần Hưng Đạo', 'Hai Bà Trưng'][array_rand(['Nguyễn Trãi', 'Lê Lợi', 'Trần Hưng Đạo', 'Hai Bà Trưng'])],
                'ward' => 'Phường ' . rand(1, 20),
                'district' => 'Quận ' . rand(1, 12),
                'city' => ['Hà Nội', 'TP.HCM', 'Đà Nẵng'][array_rand(['Hà Nội', 'TP.HCM', 'Đà Nẵng'])]
            ];

            $createdAt = Carbon::now()->subDays(rand(0, 90));
            
            // Tạo order number duy nhất
            $orderNumber = 'ORD-' . date('YmdHis') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT) . '-' . rand(100, 999);
            
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'status' => $status,
                'subtotal' => 0, // Sẽ tính sau
                'tax_amount' => 0,
                'shipping_fee' => rand(0, 50000),
                'discount_amount' => rand(0, 100000),
                'total_amount' => 0, // Sẽ tính sau
                'currency' => 'VND',
                'shipping_address' => $shippingAddress,
                'billing_address' => $shippingAddress,
                'shipping_method' => $shippingMethods[array_rand($shippingMethods)],
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_status' => $paymentStatus,
                'shipped_at' => in_array($status, ['shipped', 'delivered']) ? $createdAt->addDays(rand(1, 3)) : null,
                'delivered_at' => $status === 'delivered' ? $createdAt->addDays(rand(4, 7)) : null,
                'cancelled_at' => $status === 'cancelled' ? $createdAt->addDays(rand(1, 2)) : null,
                'notes' => rand(0, 1) ? 'Ghi chú từ khách hàng: ' . ['Giao hàng giờ hành chính', 'Gọi trước khi giao', 'Để tại bảo vệ'][array_rand(['Giao hàng giờ hành chính', 'Gọi trước khi giao', 'Để tại bảo vệ'])] : null,
                'admin_notes' => rand(0, 1) ? 'Ghi chú admin: ' . ['Khách VIP', 'Cần xử lý ưu tiên', 'Đã liên hệ khách'][array_rand(['Khách VIP', 'Cần xử lý ưu tiên', 'Đã liên hệ khách'])] : null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // Tạo order items (2-5 sản phẩm mỗi đơn)
            $numItems = rand(2, 5);
            $subtotal = 0;
            
            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random();
                $variant = $product->variants->isNotEmpty() ? $product->variants->random() : null;
                
                $quantity = rand(1, 3);
                // Đảm bảo luôn có giá, nếu không có thì dùng giá mặc định
                $unitPrice = $variant ? ($variant->price ?? 1000000) : ($product->price ?? 1000000);
                $totalPrice = $quantity * $unitPrice;
                $subtotal += $totalPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variant?->id,
                    'product_name' => $product->name,
                    'product_sku' => $variant?->sku ?? $product->sku,
                    'product_description' => $product->short_description,
                    'variant_name' => $variant?->name,
                    'variant_attributes' => $variant?->attributes,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }

            // Cập nhật tổng tiền đơn hàng
            $totalAmount = $subtotal + $order->shipping_fee - $order->discount_amount;
            $order->update([
                'subtotal' => $subtotal,
                'total_amount' => $totalAmount
            ]);

            // Tạo transaction nếu đã thanh toán
            if ($paymentStatus === 'paid') {
                $transactionNumber = 'TXN-' . date('YmdHis') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT) . '-' . rand(100, 999);
                Transaction::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'type' => 'payment',
                    'amount' => $totalAmount,
                    'currency' => 'VND',
                    'status' => 'completed',
                    'payment_method' => $order->payment_method,
                    'payment_gateway' => $order->payment_method,
                    'gateway_transaction_id' => 'GW-' . rand(100000, 999999),
                    'gateway_response' => json_encode([
                        'status' => 'success',
                        'message' => 'Thanh toán thành công',
                        'gateway_transaction_id' => 'GW-' . rand(100000, 999999)
                    ]),
                    'transaction_number' => $transactionNumber,
                    'processed_at' => $createdAt->addMinutes(rand(5, 30)),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }

        $this->command->info('Đã tạo 50 đơn hàng mẫu thành công!');
    }
} 