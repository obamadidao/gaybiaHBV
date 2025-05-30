@@ -0,0 +1,104 @@
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'title',
        'sort_order',
        'is_primary',
        'width',
        'height',
        'file_size',
        'mime_type'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
        'width' => 'integer',
        'height' => 'integer'
    ];

    /**
     * Relationship với Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope: Hình ảnh chính
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope: Sắp xếp
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Lấy URL đầy đủ của hình ảnh
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

    /**
     * Lấy alt text hoặc tên sản phẩm
     */
    public function getAltAttribute()
    {
        return $this->alt_text ?: $this->product->name;
    }

    /**
     * Lấy title hoặc tên sản phẩm
     */
    public function getTitleTextAttribute()
    {
        return $this->title ?: $this->product->name;
    }

    /**
     * Format kích thước file
     */
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) {
            return null;
        }

        $bytes = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Kiểm tra file có tồn tại không
     */
    public function exists()
    {
        return Storage::exists($this->image_path);
    }
}