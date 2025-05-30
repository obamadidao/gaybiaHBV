@@ -0,0 +1,301 @@
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'category_id',
        'brand',
        'model',
        'material',
        'base_price',
        'compare_price',
        'cost_price',
        'sku',
        'stock_quantity',
        'min_stock',
        'track_quantity',
        'weight',
        'length',
        'width',
        'height',
        'is_active',
        'is_featured',
        'is_digital'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_digital' => 'boolean',
        'track_quantity' => 'boolean',
        'stock_quantity' => 'integer',
        'min_stock' => 'integer'
    ];

    /**
     * Boot model để tự động tạo slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (!$product->slug) {
                $product->slug = Str::slug($product->name);
                
                // Đảm bảo slug là duy nhất
                $originalSlug = $product->slug;
                $count = 1;
                while (static::where('slug', $product->slug)->exists()) {
                    $product->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }

            // Tự động tạo SKU nếu chưa có
            if (!$product->sku) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8));
                while (static::where('sku', $product->sku)->exists()) {
                    $product->sku = 'PRD-' . strtoupper(Str::random(8));
                }
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && !$product->isDirty('slug')) {
                $product->slug = Str::slug($product->name);
                
                $originalSlug = $product->slug;
                $count = 1;
                while (static::where('slug', $product->slug)->where('id', '!=', $product->id)->exists()) {
                    $product->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Relationship với Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship với ProductVariant
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    /**
     * Relationship với ProductImage
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Lấy hình ảnh chính
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Relationship với ProductReview
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Lấy đánh giá đã được duyệt
     */
    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)
                    ->where('is_approved', true)
                    ->where('is_hidden', false);
    }

    /**
     * Scope: Sản phẩm hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Sản phẩm nổi bật
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Sản phẩm có trong kho
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * Scope: Tìm kiếm
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('short_description', 'like', "%{$term}%")
              ->orWhere('sku', 'like', "%{$term}%")
              ->orWhere('brand', 'like', "%{$term}%")
              ->orWhere('model', 'like', "%{$term}%");
        });
    }

    /**
     * Lấy giá cuối cùng (bao gồm biến thể)
     */
    public function getFinalPriceAttribute()
    {
        // Nếu có biến thể, lấy giá thấp nhất
        $variantMinPrice = $this->variants()
            ->where('is_active', true)
            ->min('price_adjustment');
        
        if ($variantMinPrice !== null) {
            return $this->base_price + $variantMinPrice;
        }
        
        return $this->base_price;
    }

    /**
     * Lấy giá cao nhất (với biến thể)
     */
    public function getMaxPriceAttribute()
    {
        $variantMaxPrice = $this->variants()
            ->where('is_active', true)
            ->max('price_adjustment');
        
        if ($variantMaxPrice !== null) {
            return $this->base_price + $variantMaxPrice;
        }
        
        return $this->base_price;
    }

    /**
     * Kiểm tra còn hàng
     */
    public function isInStock()
    {
        if (!$this->track_quantity) {
            return true;
        }
        
        return $this->stock_quantity > 0;
    }

    /**
     * Kiểm tra sắp hết hàng
     */
    public function isLowStock()
    {
        if (!$this->track_quantity) {
            return false;
        }
        
        return $this->stock_quantity <= $this->min_stock && $this->stock_quantity > 0;
    }

    /**
     * Lấy đánh giá trung bình
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    /**
     * Lấy tổng số đánh giá
     */
    public function getTotalReviewsAttribute()
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Lấy biến thể theo loại
     */
    public function getVariantsByType($type)
    {
        return $this->variants()
                    ->where('variant_type', $type)
                    ->where('is_active', true)
                    ->get();
    }

    /**
     * Lấy biến thể chất liệu chuôi
     */
    public function getHandleMaterialsAttribute()
    {
        return $this->getVariantsByType('handle_material');
    }

    /**
     * Lấy biến thể chất liệu đầu gậy
     */
    public function getTipMaterialsAttribute()
    {
        return $this->getVariantsByType('tip_material');
    }

    /**
     * Format giá tiền
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->base_price, 0, ',', '.') . ' VNĐ';
    }

    /**
     * Format giá so sánh
     */
    public function getFormattedComparePriceAttribute()
    {
        return $this->compare_price ? number_format($this->compare_price, 0, ',', '.') . ' VNĐ' : null;
    }
}