@@ -0,0 +1,129 @@
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'variant_type',
        'variant_name',
        'variant_value',
        'description',
        'price_adjustment',
        'cost_adjustment',
        'sku',
        'stock_quantity',
        'min_stock',
        'is_active',
        'sort_order',
        'properties'
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'cost_adjustment' => 'decimal:2',
        'is_active' => 'boolean',
        'stock_quantity' => 'integer',
        'min_stock' => 'integer',
        'sort_order' => 'integer',
        'properties' => 'array'
    ];

    // Định nghĩa các loại biến thể
    const VARIANT_TYPES = [
        'handle_material' => 'Chất liệu chuôi gậy',
        'tip_material' => 'Chất liệu đầu gậy'
    ];

    /**
     * Relationship với Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope: Biến thể hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Lọc theo loại biến thể
     */
    public function scopeByType($query, $type)
    {
        return $query->where('variant_type', $type);
    }

    /**
     * Scope: Sắp xếp
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('variant_name');
    }

    /**
     * Lấy tên loại biến thể
     */
    public function getVariantTypeNameAttribute()
    {
        return self::VARIANT_TYPES[$this->variant_type] ?? $this->variant_type;
    }

    /**
     * Lấy giá cuối cùng của biến thể
     */
    public function getFinalPriceAttribute()
    {
        return $this->product->base_price + $this->price_adjustment;
    }

    /**
     * Format giá điều chỉnh
     */
    public function getFormattedPriceAdjustmentAttribute()
    {
        $price = $this->price_adjustment;
        $formatted = number_format(abs($price), 0, ',', '.') . ' VNĐ';
        
        if ($price > 0) {
            return '+' . $formatted;
        } elseif ($price < 0) {
            return '-' . $formatted;
        }
        
        return $formatted;
    }

    /**
     * Format giá cuối cùng
     */
    public function getFormattedFinalPriceAttribute()
    {
        return number_format($this->final_price, 0, ',', '.') . ' VNĐ';
    }

    /**
     * Kiểm tra còn hàng
     */
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Kiểm tra sắp hết hàng
     */
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->min_stock && $this->stock_quantity > 0;
    }
}