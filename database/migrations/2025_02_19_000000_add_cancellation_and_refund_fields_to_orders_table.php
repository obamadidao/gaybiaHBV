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
            // Thêm trường cho thông tin hủy đơn hàng (nếu chưa có)
            if (!Schema::hasColumn('orders', 'cancellation_reason')) {
                $table->string('cancellation_reason')->nullable()->after('admin_notes');
            }
            if (!Schema::hasColumn('orders', 'cancellation_evidence')) {
                $table->string('cancellation_evidence')->nullable()->after('cancellation_reason');
            }
            if (!Schema::hasColumn('orders', 'cancelled_by')) {
                $table->unsignedBigInteger('cancelled_by')->nullable()->after('cancelled_at');
                $table->foreign('cancelled_by')->references('id')->on('users')->onDelete('set null');
            }

            // Thêm trường cho thông tin hoàn tiền (nếu chưa có)
            if (!Schema::hasColumn('orders', 'refund_reason')) {
                $table->string('refund_reason')->nullable()->after('cancelled_by');
            }
            if (!Schema::hasColumn('orders', 'refund_evidence')) {
                $table->string('refund_evidence')->nullable()->after('refund_reason');
            }
            if (!Schema::hasColumn('orders', 'refund_amount')) {
                $table->decimal('refund_amount', 12, 2)->nullable()->after('refund_evidence');
            }
            if (!Schema::hasColumn('orders', 'refunded_at')) {
                $table->timestamp('refunded_at')->nullable()->after('refund_amount');
            }
            if (!Schema::hasColumn('orders', 'refunded_by')) {
                $table->unsignedBigInteger('refunded_by')->nullable()->after('refunded_at');
                $table->foreign('refunded_by')->references('id')->on('users')->onDelete('set null');
            }

            // Thêm trường cho lịch sử trạng thái (nếu chưa có)
            if (!Schema::hasColumn('orders', 'status_history')) {
                $table->json('status_history')->nullable()->after('refunded_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa các khóa ngoại nếu tồn tại
            if (Schema::hasColumn('orders', 'cancelled_by')) {
                $table->dropForeign(['cancelled_by']);
            }
            if (Schema::hasColumn('orders', 'refunded_by')) {
                $table->dropForeign(['refunded_by']);
            }

            // Xóa các cột đã thêm
            $columns = [
                'cancellation_reason',
                'cancellation_evidence',
                'cancelled_by',
                'refund_reason',
                'refund_evidence',
                'refund_amount',
                'refunded_at',
                'refunded_by',
                'status_history'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}; 