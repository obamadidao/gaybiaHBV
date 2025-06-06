<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'user_id',
        'order_id',
        'type',
        'status',
        'amount',
        'currency',
        'payment_method',
        'payment_gateway',
        'gateway_transaction_id',
        'gateway_response',
        'description',
        'admin_notes',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Relationship với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship với Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scope để lọc theo type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope để lọc theo status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Accessor để lấy type text
     */
    protected function typeText(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match ($this->type) {
                    'payment' => 'Thanh toán',
                    'refund' => 'Hoàn tiền',
                    'adjustment' => 'Điều chỉnh',
                    default => 'Không xác định'
                };
            }
        );
    }

    /**
     * Accessor để lấy status text
     */
    protected function statusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match ($this->status) {
                    'pending' => 'Chờ xử lý',
                    'processing' => 'Đang xử lý',
                    'completed' => 'Hoàn thành',
                    'failed' => 'Thất bại',
                    'cancelled' => 'Đã hủy',
                    default => 'Không xác định'
                };
            }
        );
    }

    /**
     * Accessor để lấy status badge class
     */
    protected function statusBadgeClass(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match ($this->status) {
                    'pending' => 'bg-warning',
                    'processing' => 'bg-info',
                    'completed' => 'bg-success',
                    'failed' => 'bg-danger',
                    'cancelled' => 'bg-secondary',
                    default => 'bg-secondary'
                };
            }
        );
    }

    /**
     * Boot method để tự động tạo transaction number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (!$transaction->transaction_number) {
                $prefix = match ($transaction->type) {
                    'payment' => 'PAY',
                    'refund' => 'REF',
                    'adjustment' => 'ADJ',
                    default => 'TXN'
                };
                $transaction->transaction_number = $prefix . '-' . date('YmdHis') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
