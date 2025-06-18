<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Illuminate\Support\Carbon;

class CouponSeeder extends Seeder
{
public function run()
{
Coupon::truncate();
Coupon::insert([
[
'code' => 'SALE10',
'type' => 'percent',
'value' => 10,
                'max_discount_value' => 50000,
'min_order_value' => 200000,
'max_uses' => 100,
'used' => 0,
'start_date' => Carbon::now()->subDays(1),
'end_date' => Carbon::now()->addDays(30),
'status' => true,
                'description' => 'Giảm 10% cho đơn từ 200K',
                'description' => 'Giảm 10% cho đơn từ 200K, tối đa 50K',
'created_at' => now(),
'updated_at' => now(),
],
[
'code' => 'FREESHIP',
'type' => 'fixed',
'value' => 30000,
                'max_discount_value' => null,
'min_order_value' => 100000,
'max_uses' => 50,
'used' => 0,
'start_date' => Carbon::now()->subDays(2),
'end_date' => Carbon::now()->addDays(15),
'status' => true,
'description' => 'Giảm 30K phí ship cho đơn từ 100K',
'created_at' => now(),
'updated_at' => now(),
],
[
'code' => 'WELCOME50',
'type' => 'fixed',
'value' => 50000,
                'max_discount_value' => null,
'min_order_value' => 300000,
'max_uses' => 20,
'used' => 0,
'start_date' => Carbon::now()->subDays(5),
'end_date' => Carbon::now()->addDays(10),
'status' => true,
'description' => 'Tặng 50K cho khách mới',
'created_at' => now(),
'updated_at' => now(),
],
]);
}