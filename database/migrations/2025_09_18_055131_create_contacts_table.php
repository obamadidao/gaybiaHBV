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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            
            // Thông tin người gửi
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Nội dung liên hệ
            $table->string('subject');
            $table->text('message');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            
            // Trạng thái và xử lý
            $table->enum('status', ['pending', 'in_progress', 'replied', 'closed'])->default('pending');
            $table->timestamp('replied_at')->nullable();
            $table->foreignId('replied_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('reply_message')->nullable();
            $table->text('admin_notes')->nullable();
            
            // Thông tin tracking
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            
            $table->timestamps();
            
            // Indexes để tăng performance
            $table->index(['status', 'created_at']);
            $table->index(['email', 'created_at']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};