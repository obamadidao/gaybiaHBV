@@ -0,0 +1,51 @@
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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('ID sản phẩm');
            
            // Image details
            $table->string('image_path')->comment('Đường dẫn hình ảnh');
            $table->string('alt_text')->nullable()->comment('Alt text cho SEO');
            $table->string('title')->nullable()->comment('Title hình ảnh');
            
            // Organization
            $table->integer('sort_order')->default(0)->comment('Thứ tự sắp xếp');
            $table->boolean('is_primary')->default(false)->comment('Hình ảnh chính');
            
            // Image properties
            $table->integer('width')->nullable()->comment('Chiều rộng (px)');
            $table->integer('height')->nullable()->comment('Chiều cao (px)');
            $table->string('file_size')->nullable()->comment('Kích thước file');
            $table->string('mime_type')->nullable()->comment('Loại file');
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            
            // Indexes
            $table->index(['product_id', 'sort_order']);
            $table->index('is_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};