<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'link',
        'is_active',
        'position'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position' => 'integer'
    ];

    /**
     * Scope: Chỉ lấy banner đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Sắp xếp theo thứ tự position
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('position')->orderBy('created_at', 'desc');
    }

    /**
     * Scope: Lọc theo trạng thái
     */
    public function scopeByStatus($query, $status)
    {
        if ($status === 'active') {
            return $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            return $query->where('is_active', false);
        }
        return $query;
    }

    /**
     * Accessor: Lấy trạng thái dạng text
     */
    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Hoạt động' : 'Tạm dừng';
    }

    /**
     * Accessor: Lấy class CSS cho trạng thái
     */
    public function getStatusClassAttribute()
    {
        return $this->is_active ? 'text-success' : 'text-danger';
    }

    /**
     * Kiểm tra xem banner có link không
     */
    public function hasLink()
    {
        return !empty($this->link);
    }

    /**
     * Accessor: Lấy URL đầy đủ của hình ảnh
     */
    public function getImageUrlFullAttribute()
    {
        if ($this->image_url) {
            return asset('storage/' . $this->image_url);
        }
        return null;
    }
} 