@@ -0,0 +1,47 @@
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên danh mục');
            $table->string('slug')->unique()->comment('Slug cho URL');
            $table->text('description')->nullable()->comment('Mô tả danh mục');
            $table->string('image')->nullable()->comment('Hình ảnh danh mục');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('ID danh mục cha');
            $table->integer('sort_order')->default(0)->comment('Thứ tự sắp xếp');
            $table->boolean('is_active')->default(true)->comment('Trạng thái hoạt động');
            $table->boolean('is_featured')->default(false)->comment('Danh mục nổi bật');
            $table->string('meta_title')->nullable()->comment('Meta title SEO');
            $table->text('meta_description')->nullable()->comment('Meta description SEO');
            $table->string('meta_keywords')->nullable()->comment('Meta keywords SEO');
            $table->timestamps();
            $table->softDeletes(); // Thêm trường deleted_at cho soft delete
            
            // Tạo foreign key cho parent_id
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            
            // Tạo index
            $table->index(['parent_id', 'is_active']);
            $table->index('slug');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};