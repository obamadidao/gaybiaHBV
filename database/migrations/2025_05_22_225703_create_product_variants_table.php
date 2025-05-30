@@ -0,0 +1,63 @@
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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('ID sản phẩm');
            
            // Variant details
            $table->enum('variant_type', ['handle_material', 'tip_material'])
                  ->comment('Loại biến thể: chất liệu chuôi hoặc đầu gậy');
            $table->string('variant_name')->comment('Tên biến thể');
            $table->string('variant_value')->comment('Giá trị biến thể');
            $table->text('description')->nullable()->comment('Mô tả biến thể');
            
            // Pricing
            $table->decimal('price_adjustment', 10, 2)->default(0)
                  ->comment('Điều chỉnh giá so với giá gốc');
            $table->decimal('cost_adjustment', 10, 2)->default(0)
                  ->comment('Điều chỉnh giá vốn');
            
            // Inventory
            $table->string('sku')->nullable()->comment('Mã SKU riêng cho biến thể');
            $table->integer('stock_quantity')->default(0)->comment('Số lượng tồn kho');
            $table->integer('min_stock')->default(0)->comment('Tồn kho tối thiểu');
            
            // Status
            $table->boolean('is_active')->default(true)->comment('Trạng thái hoạt động');
            $table->integer('sort_order')->default(0)->comment('Thứ tự sắp xếp');
            
            // Additional properties
            $table->json('properties')->nullable()->comment('Thuộc tính bổ sung (JSON)');
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            
            // Indexes
            $table->index(['product_id', 'variant_type']);
            $table->index('is_active');
            $table->index('sku');
            $table->unique(['product_id', 'variant_type', 'variant_value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};