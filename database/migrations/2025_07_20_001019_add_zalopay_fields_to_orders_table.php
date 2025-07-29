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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('zalopay_trans_id')->nullable()->after('payment_method')->comment('ZaloPay transaction ID');
            $table->timestamp('paid_at')->nullable()->after('payment_status')->comment('Thời gian thanh toán');
            $table->json('payment_gateway_data')->nullable()->after('paid_at')->comment('Dữ liệu từ payment gateway');
            $table->json('zalopay_data')->nullable()->after('payment_gateway_data')->comment('Dữ liệu callback từ ZaloPay');
            
            // Index cho zalopay_trans_id
            $table->index('zalopay_trans_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['zalopay_trans_id']);
            $table->dropColumn([
                'zalopay_trans_id',
                'paid_at',
                'payment_gateway_data',
                'zalopay_data'
            ]);
        });
    }
};