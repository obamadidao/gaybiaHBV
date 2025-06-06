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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('product_name'); // Lưu tên sản phẩm tại thời điểm đặt hàng
            $table->string('product_sku')->nullable();
            $table->text('product_description')->nullable();
            $table->string('variant_name')->nullable(); // Tên biến thể
            $table->json('variant_attributes')->nullable(); // Thuộc tính biến thể (màu, size...)
            
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2); // Giá tại thời điểm đặt hàng
            $table->decimal('total_price', 15, 2); // quantity * unit_price
            
            $table->timestamps();
            
            $table->index(['order_id']);
            $table->index(['product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};