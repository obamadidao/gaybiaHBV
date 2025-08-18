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
        Schema::table('product_reviews', function (Blueprint $table) {
            // Xóa unique constraint cũ (product_id + user_id)
            // Vì bây giờ cho phép user đánh giá nhiều lần cho 1 sản phẩm từ các đơn hàng khác nhau
            $table->dropUnique(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            // Khôi phục unique constraint cũ
            $table->unique(['product_id', 'user_id']);
        });
    }
};