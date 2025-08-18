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
            $table->unsignedBigInteger('order_id')->nullable()->after('user_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            
            // Thêm unique constraint để mỗi order chỉ có thể review 1 lần cho 1 product
            $table->unique(['order_id', 'product_id'], 'unique_order_product_review');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropUnique('unique_order_product_review');
            $table->dropColumn('order_id');
        });
    }
};