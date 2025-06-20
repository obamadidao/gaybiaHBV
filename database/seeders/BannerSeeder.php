<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Sale 50% Tất Cả Sản Phẩm Bida',
                'description' => 'Khuyến mãi lớn nhất trong năm - Giảm giá 50% cho tất cả các sản phẩm bida cao cấp',
                'image_url' => 'banners/sale-banner-1.jpg',     
                'link' => '/products?sale=50',
                'position' => 1,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Bàn Bida Professional Mới Ra Mắt',
                'description' => 'Bàn bida chuyên nghiệp với chất lượng hàng đầu thế giới - Giá ưu đãi đặc biệt',
                'image_url' => 'banners/professional-table-banner.jpg',
                'link' => '/products/professional-pool-tables',
                'position' => 2,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Phụ Kiện Bida Cao Cấp',
                'description' => 'Cơ bida, bi bida, phấn bida và các phụ kiện chính hãng từ các thương hiệu nổi tiếng',
                'image_url' => 'banners/accessories-banner.jpg',
                'link' => '/categories/accessories',
                'position' => 3,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Đăng Ký Nhận Thông Tin Khuyến Mãi',
                'description' => 'Đăng ký email để nhận thông tin về các chương trình khuyến mãi hấp dẫn',
                'image_url' => 'banners/newsletter-popup.jpg',
                'link' => '#newsletter-signup',
                'position' => 4,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Hỗ Trợ Khách Hàng 24/7',
                'description' => 'Tư vấn và hỗ trợ khách hàng 24/7 - Hotline: 1900 xxxx',
                'image_url' => 'banners/support-sidebar.jpg',
                'link' => '/contact',
                'position' => 5,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Miễn Phí Vận Chuyển',
                'description' => 'Miễn phí vận chuyển cho đơn hàng trên 2 triệu đồng',
                'image_url' => 'banners/free-shipping-header.jpg',
                'link' => '/shipping-policy',
                'position' => 6,
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('banners')->insert($banners);
    }
}                           