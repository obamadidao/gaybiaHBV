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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');

            $table->enum('type', ['payment', 'refund', 'adjustment'])->default('payment');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');

            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('VND');

            // Thông tin thanh toán
            $table->string('payment_method')->nullable(); // visa, mastercard, momo, zalopay, etc.
            $table->string('payment_gateway')->nullable(); // vnpay, momo, zalopay, etc.
            $table->string('gateway_transaction_id')->nullable();
            $table->json('gateway_response')->nullable();

            // Thông tin bổ sung
            $table->text('description')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->timestamps();

            $table->index(['user_id']);
            $table->index(['order_id']);
            $table->index(['transaction_number']);
            $table->index(['status']);
            $table->index(['type']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
