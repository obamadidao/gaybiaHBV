@@ -0,0 +1,242 @@
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Xóa dữ liệu cũ nếu có
        Category::truncate();
        
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Danh mục gốc - Cấp 1
        $bidaTables = Category::create([
            'name' => 'Bàn Bida',
            'slug' => 'ban-bida',
            'description' => 'Các loại bàn bida chất lượng cao từ các thương hiệu nổi tiếng',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 1
        ]);

        $bidaCues = Category::create([
            'name' => 'Cơ Bida',
            'slug' => 'co-bida',
            'description' => 'Cơ bida chuyên nghiệp từ các thương hiệu hàng đầu thế giới',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 2
        ]);

        $bidaBalls = Category::create([
            'name' => 'Bi Bida',
            'slug' => 'bi-bida',
            'description' => 'Bộ bi bida chính hãng với độ chính xác cao',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 3
        ]);

        $accessories = Category::create([
            'name' => 'Phụ Kiện Bida',
            'slug' => 'phu-kien-bida',
            'description' => 'Các phụ kiện cần thiết cho việc chơi bida',
            'is_active' => true,
            'is_featured' => true,
            'sort_order' => 4
        ]);

        $lighting = Category::create([
            'name' => 'Đèn Bàn Bida',
            'slug' => 'den-ban-bida',
            'description' => 'Hệ thống đèn chiếu sáng chuyên dụng cho bàn bida',
            'is_active' => true,
            'is_featured' => false,
            'sort_order' => 5
        ]);

        // Danh mục con của Bàn Bida - Cấp 2
        Category::create([
            'name' => 'Bàn Bida Pool 9 Bi',
            'slug' => 'ban-bida-pool-9-bi',
            'description' => 'Bàn bida dành cho game pool 9 bi',
            'parent_id' => $bidaTables->id,
            'is_active' => true,
            'sort_order' => 1
        ]);

        Category::create([
            'name' => 'Bàn Bida Pool 8 Bi',
            'slug' => 'ban-bida-pool-8-bi',
            'description' => 'Bàn bida dành cho game pool 8 bi',
            'parent_id' => $bidaTables->id,
            'is_active' => true,
            'sort_order' => 2
        ]);

        Category::create([
            'name' => 'Bàn Bida Carom 3 Băng',
            'slug' => 'ban-bida-carom-3-bang',
            'description' => 'Bàn bida carom chuyên nghiệp',
            'parent_id' => $bidaTables->id,
            'is_active' => true,
            'sort_order' => 3
        ]);

        Category::create([
            'name' => 'Bàn Bida Snooker',
            'slug' => 'ban-bida-snooker',
            'description' => 'Bàn bida snooker kích thước chuẩn',
            'parent_id' => $bidaTables->id,
            'is_active' => true,
            'sort_order' => 4
        ]);

        // Danh mục con của Cơ Bida - Cấp 2
        $predatorCues = Category::create([
            'name' => 'Cơ Predator',
            'slug' => 'co-predator',
            'description' => 'Cơ bida thương hiệu Predator từ Mỹ',
            'parent_id' => $bidaCues->id,
            'is_active' => true,
            'sort_order' => 1
        ]);

        $mezzCues = Category::create([
            'name' => 'Cơ Mezz',
            'slug' => 'co-mezz',
            'description' => 'Cơ bida thương hiệu Mezz từ Nhật Bản',
            'parent_id' => $bidaCues->id,
            'is_active' => true,
            'sort_order' => 2
        ]);

        Category::create([
            'name' => 'Cơ McDermott',
            'slug' => 'co-mcdermott',
            'description' => 'Cơ bida thương hiệu McDermott từ Mỹ',
            'parent_id' => $bidaCues->id,
            'is_active' => true,
            'sort_order' => 3
        ]);

        Category::create([
            'name' => 'Cơ OB',
            'slug' => 'co-ob',
            'description' => 'Cơ bida thương hiệu OB từ Mỹ',
            'parent_id' => $bidaCues->id,
            'is_active' => true,
            'sort_order' => 4
        ]);


        // Danh mục con của Bi Bida - Cấp 2
        Category::create([
            'name' => 'Bi Pool',
            'slug' => 'bi-pool',
            'description' => 'Bộ bi dành cho game pool',
            'parent_id' => $bidaBalls->id,
            'is_active' => true,
            'sort_order' => 1
        ]);

        Category::create([
            'name' => 'Bi Carom',
            'slug' => 'bi-carom',
            'description' => 'Bộ bi dành cho game carom',
            'parent_id' => $bidaBalls->id,
            'is_active' => true,
            'sort_order' => 2
        ]);

        Category::create([
            'name' => 'Bi Snooker',
            'slug' => 'bi-snooker',
            'description' => 'Bộ bi dành cho game snooker',
            'parent_id' => $bidaBalls->id,
            'is_active' => true,
            'sort_order' => 3
        ]);

        // Danh mục con của Phụ Kiện - Cấp 2
        Category::create([
            'name' => 'Phấn Bida',
            'slug' => 'phan-bida',
            'description' => 'Phấn bôi đầu cơ bida các loại',
            'parent_id' => $accessories->id,
            'is_active' => true,
            'sort_order' => 1
        ]);

        Category::create([
            'name' => 'Găng Tay Bida',
            'slug' => 'gang-tay-bida',
            'description' => 'Găng tay chuyên dụng cho bida',
            'parent_id' => $accessories->id,
            'is_active' => true,
            'sort_order' => 2
        ]);

        Category::create([
            'name' => 'Giá Để Cơ',
            'slug' => 'gia-de-co',
            'description' => 'Giá đỡ, kệ để cơ bida',
            'parent_id' => $accessories->id,
            'is_active' => true,
            'sort_order' => 3
        ]);

        Category::create([
            'name' => 'Túi Đựng Cơ',
            'slug' => 'tui-dung-co',
            'description' => 'Túi, hộp đựng cơ bida',
            'parent_id' => $accessories->id,
            'is_active' => true,
            'sort_order' => 4
        ]);

        // Danh mục con của Đèn - Cấp 2
        Category::create([
            'name' => 'Đèn LED',
            'slug' => 'den-led',
            'description' => 'Đèn LED tiết kiệm điện',
            'parent_id' => $lighting->id,
            'is_active' => true,
            'sort_order' => 1
        ]);

        Category::create([
            'name' => 'Đèn Halogen',
            'slug' => 'den-halogen',
            'description' => 'Đèn halogen ánh sáng ấm',
            'parent_id' => $lighting->id,
            'is_active' => true,
            'sort_order' => 2
        ]);

        Category::create([
            'name' => 'Đèn Tiffany',
            'slug' => 'den-tiffany',
            'description' => 'Đèn trang trí kiểu Tiffany',
            'parent_id' => $lighting->id,
            'is_active' => true,
            'sort_order' => 3
        ]);

        echo "Đã tạo thành công " . Category::count() . " danh mục bida!\n";
    }
}