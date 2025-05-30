@@ -0,0 +1,207 @@
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'sort_order',
        'is_active',
        'is_featured'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Tự động tạo slug khi tạo mới
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (!$category->slug) {
                $category->slug = Str::slug($category->name);

                // Đảm bảo slug là duy nhất
                $originalSlug = $category->slug;
                $count = 1;
                while (static::where('slug', $category->slug)->exists()) {
                    $category->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);

                // Đảm bảo slug là duy nhất (trừ chính nó)
                $originalSlug = $category->slug;
                $count = 1;
                while (static::where('slug', $category->slug)->where('id', '!=', $category->id)->exists()) {
                    $category->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Quan hệ với danh mục cha
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Quan hệ với danh mục con
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Quan hệ với tất cả danh mục con (đệ quy)
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    /**
     * Lấy đường dẫn đầy đủ từ gốc đến danh mục hiện tại
     */
    public function getFullPathAttribute()
    {
        $path = [];
        $current = $this;

        while ($current) {
            array_unshift($path, $current->name);
            $current = $current->parent;
        }

        return implode(' > ', $path);
    }

    /**
     * Lấy cấp độ của danh mục (0 = gốc, 1 = cấp 1, ...)
     */
    public function getLevelAttribute()
    {
        $level = 0;
        $current = $this;

        while ($current->parent) {
            $level++;
            $current = $current->parent;
        }

        return $level;
    }

    /**
     * Kiểm tra xem có phải danh mục gốc không
     */
    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    /**
     * Kiểm tra xem có danh mục con không
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Scope: Chỉ lấy danh mục đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Chỉ lấy danh mục gốc
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope: Chỉ lấy danh mục nổi bật
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Sắp xếp theo thứ tự
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Lấy tất cả ID của danh mục và các danh mục con
     */
    public function getAllChildrenIds()
    {
        $ids = collect([$this->id]);

        foreach ($this->children as $child) {
            $ids = $ids->merge($child->getAllChildrenIds());
        }

        return $ids->unique()->values()->toArray();
    }

    /**
     * Kiểm tra xem có thể xóa danh mục không (không có danh mục con)
     */
    public function canDelete()
    {
        return !$this->hasChildren();
    }

    /**
     * Relationship với Products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Lấy số lượng sản phẩm hoạt động
     */
    public function getActiveProductsCountAttribute()
    {
        return $this->products()->where('is_active', true)->count();
    }
}
