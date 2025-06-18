<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount_value',
        'min_order_value',
        'max_uses',
        'used',
        'start_date',
        'end_date',
        'status',
        'description',
    ];

    protected $casts = [
        'value' => 'float',
        'max_discount_value' => 'float',
        'min_order_value' => 'float',
        'max_uses' => 'integer',
        'used' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => 'boolean',
    ];

    // Hiển thị loại mã giảm giá
    public function getTypeTextAttribute()
    {
        return $this->type === 'percent' ? 'Phần trăm' : 'Tiền mặt';
    }

    // Hiển thị trạng thái
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Kích hoạt' : 'Tắt';
    }

    // Kiểm tra còn hạn sử dụng
    public function isActive()
    {
        $now = now();
        return $this->status
            && (!$this->start_date || $this->start_date <= $now)
            && (!$this->end_date || $this->end_date >= $now)
            && ($this->max_uses === null || $this->used < $this->max_uses);
    }
}