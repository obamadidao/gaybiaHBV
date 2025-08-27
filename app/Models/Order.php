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
        'payment_status',
        'payment_method',
        'shipping_address',
        'billing_address',
        'shipping_method',
        'shipping_fee',
        'discount_amount',
        'subtotal',
        'tax_amount',
        'total_amount',
        'currency',
        'notes',
        'admin_notes',
        'cancellation_reason',
        'cancellation_evidence',
        'cancelled_by',
        'refund_reason',
        'refund_evidence',
        'refund_amount',
        'refunded_by',
        'status_history',
        'zalopay_trans_id',
        'paid_at',
        'payment_gateway_data',
        'zalopay_data'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'refunded_at' => 'datetime',
        'paid_at' => 'datetime',
        'payment_gateway_data' => 'array',
        'zalopay_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status_history' => 'array',
    ];

    /**
     * Relationship với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship với OrderItems
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship với Transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope để lọc đơn hàng theo status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope để lọc đơn hàng theo payment status
     */
    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    /**
     * Accessor để lấy status badge class
     */
    protected function statusBadgeClass(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match ($this->status) {
                    'pending' => 'warning',
                    'confirmed' => 'info',
                    'processing' => 'info',
                    'shipped' => 'primary',
                    'delivered' => 'success',
                    'cancelled' => 'danger',
                    'refunded' => 'secondary',
                    default => 'secondary'
                };
            }
        );
    }

    /**
     * Relationship với Customer
     */
    public function customer()
    {
        return $this->belongsTo(CustomerProfile::class, 'user_id', 'user_id');
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
                    'confirmed' => 'Đã xác nhận',
                    'processing' => 'Đang xử lý',
                    'shipped' => 'Đã gửi',
                    'delivered' => 'Đã giao',
                    'cancelled' => 'Đã hủy',
                    'refunded' => 'Đã hoàn tiền',
                    default => 'Không xác định'
                };
            }
        );
    }

    /**
     * Accessor để lấy payment status text
     */
    protected function paymentStatusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match ($this->payment_status) {
                    'pending' => 'Chờ thanh toán',
                    'paid' => 'Đã thanh toán',
                    'failed' => 'Thanh toán thất bại',
                    'refunded' => 'Đã hoàn tiền',
                    default => 'Không xác định'
                };
            }
        );
    }

    /**
     * Kiểm tra đơn hàng có thể hủy không
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'processing']);
    }

    /**
     * Kiểm tra đơn hàng có thể hoàn tiền không
     */
    public function canBeRefunded(): bool
    {
        return $this->status === 'delivered' && $this->payment_status === 'paid';
    }

    /**
     * Boot method để tự động tạo order number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'ORD-' . date('YmdHis') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
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
        return match ($this->status) {
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
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
        return match ($this->payment_status) {
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
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đã gửi hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
            'refunded' => 'Đã hoàn tiền'
        ];

        if (!$this->status_history) {
            return [];
        }

        return array_map(function ($history) use ($statusMap) {
            return [
                'status' => $statusMap[$history['status']] ?? 'Không xác định',
                'note' => $history['note'],
                'timestamp' => $history['timestamp']
            ];
        }, $this->status_history);
    }
}
