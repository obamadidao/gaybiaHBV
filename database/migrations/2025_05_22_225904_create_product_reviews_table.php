@@ -0,0 +1,67 @@
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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('ID sản phẩm');
            $table->unsignedBigInteger('user_id')->comment('ID người đánh giá');
            
            // Review content
            $table->integer('rating')->comment('Điểm đánh giá (1-5)');
            $table->string('title')->nullable()->comment('Tiêu đề đánh giá');
            $table->text('content')->comment('Nội dung đánh giá');
            
            // Review details
            $table->json('pros')->nullable()->comment('Ưu điểm (JSON array)');
            $table->json('cons')->nullable()->comment('Nhược điểm (JSON array)');
            
            // Moderation
            $table->boolean('is_approved')->default(false)->comment('Đã duyệt');
            $table->boolean('is_hidden')->default(false)->comment('Đã ẩn');
            $table->boolean('is_verified_purchase')->default(false)->comment('Mua hàng đã xác minh');
            
            // Helpful votes
            $table->integer('helpful_count')->default(0)->comment('Số lượt hữu ích');
            $table->integer('unhelpful_count')->default(0)->comment('Số lượt không hữu ích');
            
            // Admin notes
            $table->text('admin_notes')->nullable()->comment('Ghi chú admin');
            $table->timestamp('approved_at')->nullable()->comment('Thời gian duyệt');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('Người duyệt');
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            
            // Indexes
            $table->index(['product_id', 'is_approved', 'is_hidden']);
            $table->index(['user_id', 'created_at']);
            $table->index('rating');
            $table->index('is_verified_purchase');
            
            // Unique constraint - một user chỉ đánh giá một lần cho mỗi sản phẩm
            $table->unique(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};