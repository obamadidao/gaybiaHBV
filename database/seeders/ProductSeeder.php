@@ -0,0 +1,267 @@
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy các category
        $categories = Category::all();
        if ($categories->isEmpty()) {
            $this->command->error('Vui lòng chạy CategorySeeder trước!');
            return;
        }

        $products = [
            [
                'name' => 'Cơ Gậy Bida Predator 314³ Shaft',
                'description' => 'Cơ gậy bida cao cấp với shaft 314³ nổi tiếng của Predator. Thiết kế chuyên nghiệp cho những pha bida chính xác và mượt mà. Chất liệu gỗ tự nhiên được tuyển chọn kỹ lưỡng, gia công tinh xảo.',
                'short_description' => 'Cơ gậy bida cao cấp Predator với shaft 314³ chuyên nghiệp',
                'category_id' => $categories->where('name', 'Cơ gậy bida')->first()?->id ?? $categories->first()->id,
                'brand' => 'Predator',
                'model' => '314³ Shaft',
                'material' => 'Gỗ Maple',
                'base_price' => 1500000,
                'compare_price' => 1800000,
                'cost_price' => 1200000,
                'stock_quantity' => 15,
                'min_stock' => 3,
                'weight' => 520,
                'length' => 147,
                'is_featured' => true,
                'variants' => [
                    [
                        'variant_type' => 'handle_material',
                        'variant_name' => 'Chất liệu chuôi',
                        'variant_value' => 'Gỗ Ebony',
                        'description' => 'Chuôi gỗ Ebony cao cấp, bền đẹp',
                        'price_adjustment' => 0,
                        'stock_quantity' => 8,
                        'sort_order' => 1
                    ],
                    [
                        'variant_type' => 'handle_material',
                        'variant_name' => 'Chất liệu chuôi',
                        'variant_value' => 'Gỗ Rosewood',
                        'description' => 'Chuôi gỗ Rosewood sang trọng',
                        'price_adjustment' => 200000,
                        'stock_quantity' => 4,
                        'sort_order' => 2
                    ],
                    [
                        'variant_type' => 'tip_material',
                        'variant_name' => 'Chất liệu đầu gậy',
                        'variant_value' => 'Da Tiger',
                        'description' => 'Đầu gậy da Tiger chất lượng cao',
                        'price_adjustment' => 0,
                        'stock_quantity' => 10,
                        'sort_order' => 1
                    ],
                    [
                        'variant_type' => 'tip_material',
                        'variant_name' => 'Chất liệu đầu gậy',
                        'variant_value' => 'Da Elk Master',
                        'description' => 'Đầu gậy da Elk Master premium',
                        'price_adjustment' => 150000,
                        'stock_quantity' => 5,
                        'sort_order' => 2
                    ]
                ]
            ],
            [
                'name' => 'Cơ Gậy Bida McDermott G-Core',
                'description' => 'Cơ gậy bida McDermott với công nghệ G-Core độc quyền. Thiết kế đẹp mắt với inlay tinh xảo, cho cảm giác chơi tuyệt vời. Thích hợp cho cả người chơi nghiệp dư và chuyên nghiệp.',
                'short_description' => 'Cơ gậy McDermott G-Core với công nghệ độc quyền',
                'category_id' => $categories->where('name', 'Cơ gậy bida')->first()?->id ?? $categories->first()->id,
                'brand' => 'McDermott',
                'model' => 'G-Core',
                'material' => 'Gỗ Maple',
                'base_price' => 2200000,
                'compare_price' => 2500000,
                'cost_price' => 1800000,
                'stock_quantity' => 10,
                'min_stock' => 2,
                'weight' => 535,
                'length' => 147,
                'is_featured' => true,
                'variants' => [
                    [
                        'variant_type' => 'handle_material',
                        'variant_name' => 'Chất liệu chuôi',
                        'variant_value' => 'Gỗ Cocobolo',
                        'description' => 'Chuôi gỗ Cocobolo tự nhiên',
                        'price_adjustment' => 0,
                        'stock_quantity' => 6,
                        'sort_order' => 1
                    ],
                    [
                        'variant_type' => 'handle_material',
                        'variant_name' => 'Chất liệu chuôi',
                        'variant_value' => 'Gỗ Kingwood',
                        'description' => 'Chuôi gỗ Kingwood hiếm',
                        'price_adjustment' => 300000,
                        'stock_quantity' => 4,
                        'sort_order' => 2
                    ],
                    [
                        'variant_type' => 'tip_material',
                        'variant_name' => 'Chất liệu đầu gậy',
                        'variant_value' => 'Da Kamui',
                        'description' => 'Đầu gậy da Kamui Nhật Bản',
                        'price_adjustment' => 100000,
                        'stock_quantity' => 8,
                        'sort_order' => 1
                    ]
                ]
            ],
            [
                'name' => 'Bàn Bida Pool Diamond Pro-Am',
                'description' => 'Bàn bida Pool chuyên nghiệp Diamond Pro-Am, được sử dụng trong các giải đấu quốc tế. Khung thép chắc chắn, mặt đá slate tự nhiên, cushion Artemis cao cấp đảm bảo độ nảy chuẩn xác.',
                'short_description' => 'Bàn bida Pool Diamond Pro-Am chuyên nghiệp cho giải đấu',
                'category_id' => $categories->where('name', 'Bàn bida')->first()?->id ?? $categories->first()->id,
                'brand' => 'Diamond',
                'model' => 'Pro-Am',
                'material' => 'Đá Slate',
                'base_price' => 85000000,
                'compare_price' => 95000000,
                'cost_price' => 70000000,
                'stock_quantity' => 3,
                'min_stock' => 1,
                'weight' => 450000,
                'length' => 254,
                'width' => 127,
                'height' => 80,
                'is_featured' => true,
                'variants' => [
                    [
                        'variant_type' => 'handle_material',
                        'variant_name' => 'Chất liệu khung',
                        'variant_value' => 'Gỗ Sồi',
                        'description' => 'Khung gỗ sồi tự nhiên',
                        'price_adjustment' => 0,
                        'stock_quantity' => 2,
                        'sort_order' => 1
                    ],
                    [
                        'variant_type' => 'handle_material',
                        'variant_name' => 'Chất liệu khung',
                        'variant_value' => 'Gỗ Walnut',
                        'description' => 'Khung gỗ walnut cao cấp',
                        'price_adjustment' => 5000000,
                        'stock_quantity' => 1,
                        'sort_order' => 2
                    ]
                ]
            ],
            [
                'name' => 'Bi Bida Aramith Tournament',
                'description' => 'Bộ bi bida Aramith Tournament chính hãng từ Bỉ. Chất liệu phenolic resin cao cấp, độ bền và độ chính xác tuyệt đối. Được sử dụng trong các giải đấu thế giới, màu sắc bền đẹp theo thời gian.',
                'short_description' => 'Bộ bi bida Aramith Tournament chính hãng từ Bỉ',
                'category_id' => $categories->where('name', 'Bi bida')->first()?->id ?? $categories->first()->id,
                'brand' => 'Aramith',
                'model' => 'Tournament',
                'material' => 'Phenolic Resin',
                'base_price' => 3500000,
                'compare_price' => 4000000,
                'cost_price' => 2800000,
                'stock_quantity' => 25,
                'min_stock' => 5,
                'weight' => 170,
                'is_featured' => false,
                'variants' => []
            ],
            [
                'name' => 'Phấn Bida Predator 1080 Pure',
                'description' => 'Phấn bida Predator 1080 Pure - sản phẩm đột phá trong ngành bida. Công thức đặc biệt giúp tăng ma sát, giảm trượt gậy, cho độ chính xác cao. Không bám bẩn trên bi và nỉ.',
                'short_description' => 'Phấn bida Predator 1080 Pure công nghệ đột phá',
                'category_id' => $categories->where('name', 'Phụ kiện')->first()?->id ?? $categories->first()->id,
                'brand' => 'Predator',
                'model' => '1080 Pure',
                'material' => 'Composite đặc biệt',
                'base_price' => 450000,
                'compare_price' => 500000,
                'cost_price' => 350000,
                'stock_quantity' => 50,
                'min_stock' => 10,
                'weight' => 15,
                'is_featured' => false,
                'variants' => []
            ],
            [
                'name' => 'Cơ Gậy Bida Meucci Black Dot',
                'description' => 'Cơ gậy bida Meucci Black Dot với thiết kế cổ điển và chất lượng vượt trội. Sử dụng gỗ maple cao cấp, gia công tỉ mỉ tạo nên cảm giác chơi tuyệt vời. Thích hợp cho người chơi mọi trình độ.',
                'short_description' => 'Cơ gậy Meucci Black Dot thiết kế cổ điển',
                'category_id' => $categories->where('name', 'Cơ gậy bida')->first()?->id ?? $categories->first()->id,
                'brand' => 'Meucci',
                'model' => 'Black Dot',
                'material' => 'Gỗ Maple',
                'base_price' => 1800000,
                'compare_price' => 2100000,
                'cost_price' => 1400000,
                'stock_quantity' => 12,
                'min_stock' => 3,
                'weight' => 525,
                'length' => 147,
                'is_featured' => false,
                'variants' => [
                    [
                        'variant_type' => 'handle_material',
                        'variant_name' => 'Chất liệu chuôi',
                        'variant_value' => 'Gỗ Maple',
                        'description' => 'Chuôi gỗ maple tự nhiên',
                        'price_adjustment' => 0,
                        'stock_quantity' => 8,
                        'sort_order' => 1
                    ],
                    [
                        'variant_type' => 'handle_material',
                        'variant_name' => 'Chất liệu chuôi',
                        'variant_value' => 'Gỗ Birdseye Maple',
                        'description' => 'Chuôi gỗ birdseye maple đặc biệt',
                        'price_adjustment' => 250000,
                        'stock_quantity' => 4,
                        'sort_order' => 2
                    ],
                    [
                        'variant_type' => 'tip_material',
                        'variant_name' => 'Chất liệu đầu gậy',
                        'variant_value' => 'Da Triangle',
                        'description' => 'Đầu gậy da Triangle chất lượng',
                        'price_adjustment' => 0,
                        'stock_quantity' => 10,
                        'sort_order' => 1
                    ]
                ]
            ]
        ];

        foreach ($products as $productData) {
            $variants = $productData['variants'] ?? [];
            unset($productData['variants']);

            // Tạo sản phẩm
            $product = Product::create($productData);

            // Tạo variants
            foreach ($variants as $variantData) {
                $variantData['product_id'] = $product->id;
                ProductVariant::create($variantData);
            }

            $this->command->info("Đã tạo sản phẩm: {$product->name}");
        }

        $this->command->info('Đã tạo ' . count($products) . ' sản phẩm mẫu thành công!');
    }
}