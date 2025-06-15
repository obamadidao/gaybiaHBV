<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
use HasFactory;

protected $fillable = [
'order_number',
'user_id',
'status',
        'subtotal',
        'tax_amount',
        'payment_status',
        'payment_method',
        'shipping_address',
'shipping_fee',
'discount_amount',
        'subtotal',
'total_amount',
        'currency',
        'shipping_address',
        'billing_address',
        'shipping_method',
        'payment_method',
        'payment_status',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
'notes',
'admin_notes',
        'cancellation_reason',
        'cancellation_evidence',
        'cancelled_by',
        'refund_reason',
        'refund_evidence',
        'refund_amount',
        'refunded_by',
        'status_history'
];

protected $casts = [
@@ -43,6 +44,10 @@
'shipped_at' => 'datetime',
'delivered_at' => 'datetime',
'cancelled_at' => 'datetime',
        'refunded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status_history' => 'array',
];

/**
@@ -180,4 +185,85 @@
}
});
}

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public function refundedBy()
    {
        return $this->belongsTo(User::class, 'refunded_by');
    }

    public function addStatusHistory($status, $note = null, $userId = null)
    {
        $history = $this->status_history ?? [];
        $history[] = [
            'status' => $status,
            'note' => $note,
            'user_id' => $userId,
            'timestamp' => now()->toDateTimeString()
        ];
        $this->status_history = $history;
        $this->save();
    }

    public function getStatusHistoryAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setStatusHistoryAttribute($value)
    {
        $this->attributes['status_history'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã gửi hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
            'refunded' => 'Đã hoàn tiền',
            default => 'Không xác định'
        };
    }

    public function getPaymentStatusTextAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'refunded' => 'Đã hoàn tiền',
            default => 'Không xác định'
        };
    }

    public function getStatusHistoryTextAttribute()
    {
        $statusMap = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã gửi hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
            'refunded' => 'Đã hoàn tiền'
        ];

        if (!$this->status_history) {
            return [];
        }

        return array_map(function($history) use ($statusMap) {
            return [
                'status' => $statusMap[$history['status']] ?? 'Không xác định',
                'note' => $history['note'],
                'timestamp' => $history['timestamp']
            ];
        }, $this->status_history);
    }
} 
