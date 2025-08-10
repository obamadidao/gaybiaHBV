<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Role;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy role user
        $userRole = Role::where('name', 'user')->first();

        if (!$userRole) {
            $this->command->error('Role "user" không tồn tại. Hãy chạy RoleSeeder trước.');
            return;
        }

        // Dữ liệu mẫu khách hàng
        $customers = [
            [
                'user' => [
                    'name' => 'Nguyễn Văn An',
                    'email' => 'nguyenvanan@gmail.com',
                    'password' => Hash::make('123456'),
                    'role_id' => $userRole->id,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'first_name' => 'Nguyễn Văn',
                    'last_name' => 'An',
                    'phone' => '0901234567',
                    'date_of_birth' => '1990-05-15',
                    'gender' => 'male',
                    'address' => '123 Nguyễn Huệ',
                    'city' => 'Hồ Chí Minh',
                    'district' => 'Quận 1',
                    'ward' => 'Phường Bến Nghé',
                    'postal_code' => '70000',
                    'country' => 'Vietnam',
                    'is_verified' => true,
                    'verified_at' => now(),
                ]
            ],
            [
                'user' => [
                    'name' => 'Trần Thị Bình',
                    'email' => 'tranthibinh@gmail.com',
                    'password' => Hash::make('123456'),
                    'role_id' => $userRole->id,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'first_name' => 'Trần Thị',
                    'last_name' => 'Bình',
                    'phone' => '0902345678',
                    'date_of_birth' => '1995-08-22',
                    'gender' => 'female',
                    'address' => '456 Lê Lợi',
                    'city' => 'Hà Nội',
                    'district' => 'Quận Hoàn Kiếm',
                    'ward' => 'Phường Tràng Tiền',
                    'postal_code' => '10000',
                    'country' => 'Vietnam',
                    'is_verified' => true,
                    'verified_at' => now(),
                ]
            ],
            [
                'user' => [
                    'name' => 'Lê Minh Châu',
                    'email' => 'leminhchau@gmail.com',
                    'password' => Hash::make('123456'),
                    'role_id' => $userRole->id,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'first_name' => 'Lê Minh',
                    'last_name' => 'Châu',
                    'phone' => '0903456789',
                    'date_of_birth' => '1992-12-10',
                    'gender' => 'male',
                    'address' => '789 Trường Chinh',
                    'city' => 'Đà Nẵng',
                    'district' => 'Quận Thanh Khê',
                    'ward' => 'Phường Thanh Khê Tây',
                    'postal_code' => '50000',
                    'country' => 'Vietnam',
                    'is_verified' => false,
                ]
            ],
            [
                'user' => [
                    'name' => 'Phạm Thị Dung',
                    'email' => 'phamthidung@gmail.com',
                    'password' => Hash::make('123456'),
                    'role_id' => $userRole->id,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'first_name' => 'Phạm Thị',
                    'last_name' => 'Dung',
                    'phone' => '0904567890',
                    'date_of_birth' => '1988-03-25',
                    'gender' => 'female',
                    'address' => '321 Võ Văn Tần',
                    'city' => 'Hồ Chí Minh',
                    'district' => 'Quận 3',
                    'ward' => 'Phường Võ Thị Sáu',
                    'postal_code' => '70000',
                    'country' => 'Vietnam',
                    'is_verified' => true,
                    'verified_at' => now(),
                ]
            ],
            [
                'user' => [
                    'name' => 'Hoàng Văn Em',
                    'email' => 'hoangvanem@gmail.com',
                    'password' => Hash::make('123456'),
                    'role_id' => $userRole->id,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'first_name' => 'Hoàng Văn',
                    'last_name' => 'Em',
                    'phone' => '0905678901',
                    'date_of_birth' => '1993-07-18',
                    'gender' => 'male',
                    'address' => '654 Hai Bà Trưng',
                    'city' => 'Hải Phòng',
                    'district' => 'Quận Ngô Quyền',
                    'ward' => 'Phường Máy Chai',
                    'postal_code' => '18000',
                    'country' => 'Vietnam',
                    'is_verified' => false,
                ]
            ],
            [
                'user' => [
                    'name' => 'Vũ Thị Phương',
                    'email' => 'vuthiphuong@gmail.com',
                    'password' => Hash::make('123456'),
                    'role_id' => $userRole->id,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'first_name' => 'Vũ Thị',
                    'last_name' => 'Phương',
                    'phone' => '0906789012',
                    'date_of_birth' => '1991-11-05',
                    'gender' => 'female',
                    'address' => '987 Nguyễn Trãi',
                    'city' => 'Hà Nội',
                    'district' => 'Quận Thanh Xuân',
                    'ward' => 'Phường Khương Trung',
                    'postal_code' => '10000',
                    'country' => 'Vietnam',
                    'is_verified' => true,
                    'verified_at' => now(),
                ]
            ],
            [
                'user' => [
                    'name' => 'Đặng Minh Giang',
                    'email' => 'dangminhgiang@gmail.com',
                    'password' => Hash::make('123456'),
                    'role_id' => $userRole->id,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'first_name' => 'Đặng Minh',
                    'last_name' => 'Giang',
                    'phone' => '0907890123',
                    'date_of_birth' => '1989-09-30',
                    'gender' => 'male',
                    'address' => '159 Lý Tự Trọng',
                    'city' => 'Cần Thơ',
                    'district' => 'Quận Ninh Kiều',
                    'ward' => 'Phường Cái Khế',
                    'postal_code' => '94000',
                    'country' => 'Vietnam',
                    'is_verified' => true,
                    'verified_at' => now(),
                ]
            ],
            [
                'user' => [
                    'name' => 'Bùi Thị Hồng',
                    'email' => 'buithihong@gmail.com',
                    'password' => Hash::make('123456'),
                    'role_id' => $userRole->id,
                    'email_verified_at' => now(),
                ],
                'profile' => [
                    'first_name' => 'Bùi Thị',
                    'last_name' => 'Hồng',
                    'phone' => '0908901234',
                    'date_of_birth' => '1994-04-12',
                    'gender' => 'female',
                    'address' => '753 Điện Biên Phủ',
                    'city' => 'Hồ Chí Minh',
                    'district' => 'Quận Bình Thạnh',
                    'ward' => 'Phường 25',
                    'postal_code' => '70000',
                    'country' => 'Vietnam',
                    'is_verified' => false,
                ]
            ]
        ];

        $this->command->info('Đang tạo dữ liệu khách hàng...');

        foreach ($customers as $index => $customerData) {
            // Tạo user
            $user = User::create($customerData['user']);

            // Tạo customer profile
            $customerData['profile']['user_id'] = $user->id;
            CustomerProfile::create($customerData['profile']);

            $this->command->info("Đã tạo khách hàng: {$user->name}");

            // Tạo một số đơn hàng mẫu cho một số khách hàng
            if ($index < 4) { // Chỉ tạo đơn hàng cho 4 khách hàng đầu
                $this->createSampleOrders($user);
            }
        }

        $this->command->info('Hoàn thành tạo dữ liệu khách hàng!');
    }

    /**
     * Tạo đơn hàng mẫu cho khách hàng
     */
    private function createSampleOrders($user)
    {
        $products = Product::limit(5)->get();

        if ($products->count() == 0) {
            return;
        }

        // Tạo 1-3 đơn hàng cho mỗi khách hàng
        $orderCount = rand(1, 3);

        for ($i = 0; $i < $orderCount; $i++) {
            $order = Order::create([
                'user_id' => $user->id,
                'status' => ['pending', 'processing', 'delivered', 'cancelled'][rand(0, 3)],
                'payment_status' => ['pending', 'paid', 'failed'][rand(0, 2)],
                'subtotal' => 0,
                'tax_amount' => 0,
                'shipping_fee' => 30000,
                'discount_amount' => 0,
                'total_amount' => 0,
                'currency' => 'VND',
                'shipping_address' => [
                    'name' => $user->customerProfile->first_name . ' ' . $user->customerProfile->last_name,
                    'phone' => $user->customerProfile->phone,
                    'address' => $user->customerProfile->address,
                    'city' => $user->customerProfile->city,
                    'district' => $user->customerProfile->district,
                    'ward' => $user->customerProfile->ward,
                ],
                'billing_address' => [
                    'name' => $user->customerProfile->first_name . ' ' . $user->customerProfile->last_name,
                    'phone' => $user->customerProfile->phone,
                    'address' => $user->customerProfile->address,
                    'city' => $user->customerProfile->city,
                    'district' => $user->customerProfile->district,
                    'ward' => $user->customerProfile->ward,
                ],
                'shipping_method' => 'standard',
                'payment_method' => ['cod', 'bank_transfer', 'momo'][rand(0, 2)],
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);

            // Tạo order items
            $itemCount = rand(1, 3);
            $subtotal = 0;

            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 2);
                $unitPrice = $product->base_price;
                $totalPrice = $quantity * $unitPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'product_description' => $product->short_description,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                ]);

                $subtotal += $totalPrice;
            }

            // Cập nhật tổng tiền đơn hàng
            $order->update([
                'subtotal' => $subtotal,
                'total_amount' => $subtotal + 30000, // + shipping fee
            ]);

            // Tạo transaction nếu đã thanh toán
            if ($order->payment_status == 'paid') {
                Transaction::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'type' => 'payment',
                    'status' => 'completed',
                    'amount' => $order->total_amount,
                    'currency' => 'VND',
                    'payment_method' => $order->payment_method,
                    'payment_gateway' => 'vnpay',
                    'description' => "Thanh toán đơn hàng {$order->order_number}",
                    'processed_at' => $order->created_at->addMinutes(5),
                    'created_at' => $order->created_at->addMinutes(5),
                    'updated_at' => $order->created_at->addMinutes(5),
                ]);
            }
        }
    }
}
