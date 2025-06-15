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
'shipping_fee',
'discount_amount',
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
return match($this->status) {
'pending' => 'bg-warning',
'processing' => 'bg-info',
'shipped' => 'bg-primary',
'delivered' => 'bg-success',
'cancelled' => 'bg-danger',
'refunded' => 'bg-secondary',
default => 'bg-secondary'
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
return match($this->status) {
'pending' => 'Chờ xử lý',
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
return match($this->payment_status) {
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
return in_array($this->status, ['pending', 'processing']);
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
}