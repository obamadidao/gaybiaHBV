@@ -0,0 +1,78 @@
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên sản phẩm');
            $table->string('slug')->unique()->comment('Slug cho URL');
            $table->text('description')->nullable()->comment('Mô tả chi tiết');
            $table->text('short_description')->nullable()->comment('Mô tả ngắn');
            
            // Category relationship
            $table->unsignedBigInteger('category_id')->comment('ID danh mục');
            
            // Product details
            $table->string('brand')->nullable()->comment('Thương hiệu');
            $table->string('model')->nullable()->comment('Mẫu sản phẩm');
            $table->string('material')->nullable()->comment('Chất liệu chính');
            
            // Pricing
            $table->decimal('base_price', 12, 2)->comment('Giá cơ bản');
            $table->decimal('compare_price', 12, 2)->nullable()->comment('Giá so sánh');
            $table->decimal('cost_price', 12, 2)->nullable()->comment('Giá vốn');
            
            // Inventory
            $table->string('sku')->unique()->comment('Mã sản phẩm');
            $table->integer('stock_quantity')->default(0)->comment('Số lượng tồn kho');
            $table->integer('min_stock')->default(0)->comment('Số lượng tồn kho tối thiểu');
            $table->boolean('track_quantity')->default(true)->comment('Theo dõi số lượng');
            
            // Physical properties
            $table->decimal('weight', 8, 2)->nullable()->comment('Trọng lượng (gram)');
            $table->decimal('length', 8, 2)->nullable()->comment('Chiều dài (cm)');
            $table->decimal('width', 8, 2)->nullable()->comment('Chiều rộng (cm)');
            $table->decimal('height', 8, 2)->nullable()->comment('Chiều cao (cm)');
            
            // Status
            $table->boolean('is_active')->default(true)->comment('Trạng thái hoạt động');
            $table->boolean('is_featured')->default(false)->comment('Sản phẩm nổi bật');
            $table->boolean('is_digital')->default(false)->comment('Sản phẩm số');
            
            // SEO
            $table->string('meta_title')->nullable()->comment('Meta title SEO');
            $table->text('meta_description')->nullable()->comment('Meta description SEO');
            $table->string('meta_keywords')->nullable()->comment('Meta keywords SEO');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            
            // Indexes
            $table->index(['category_id', 'is_active']);
            $table->index('slug');
            $table->index('sku');
            $table->index('is_featured');
            $table->index('brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};