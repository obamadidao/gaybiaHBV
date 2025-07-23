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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(); // Cho khách hàng chưa đăng nhập
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Cho khách hàng đã đăng nhập
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->json('selected_variants')->nullable(); // Lưu variants đã chọn
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2); // Giá tại thời điểm thêm vào giỏ
            $table->decimal('total_price', 10, 2); // Tổng giá (unit_price * quantity)
            $table->timestamps();
            
            // Index để tối ưu query
            $table->index(['session_id']);
            $table->index(['user_id']);
            $table->index(['product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};