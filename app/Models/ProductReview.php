@@ -0,0 +1,248 @@
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'title',
        'content',
        'pros',
        'cons',
        'is_approved',
        'is_hidden',
        'is_verified_purchase',
        'helpful_count',
        'unhelpful_count',
        'admin_notes',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'rating' => 'integer',
        'pros' => 'array',
        'cons' => 'array',
        'is_approved' => 'boolean',
        'is_hidden' => 'boolean',
        'is_verified_purchase' => 'boolean',
        'helpful_count' => 'integer',
        'unhelpful_count' => 'integer',
        'approved_at' => 'datetime'
    ];

    /**
     * Relationship với Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship với User (người đánh giá)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship với User (người duyệt)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope: Đánh giá đã được duyệt
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope: Đánh giá không bị ẩn
     */
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Scope: Đánh giá công khai (đã duyệt và không ẩn)
     */
    public function scopePublic($query)
    {
        return $query->approved()->visible();
    }

    /**
     * Scope: Đánh giá chờ duyệt
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Scope: Lọc theo rating
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope: Đánh giá mua hàng đã xác minh
     */
    public function scopeVerifiedPurchase($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    /**
     * Lấy mảng sao cho hiển thị
     */
    public function getStarsArrayAttribute()
    {
        $stars = [];
        for ($i = 1; $i <= 5; $i++) {
            $stars[] = $i <= $this->rating;
        }
        return $stars;
    }

    /**
     * Lấy text rating
     */
    public function getRatingTextAttribute()
    {
        $ratings = [
            1 => 'Rất tệ',
            2 => 'Tệ',
            3 => 'Trung bình',
            4 => 'Tốt',
            5 => 'Rất tốt'
        ];

        return $ratings[$this->rating] ?? 'Chưa đánh giá';
    }

    /**
     * Lấy số ngày từ khi đánh giá
     */
    public function getDaysAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Kiểm tra đánh giá có hữu ích không
     */
    public function isHelpful()
    {
        return $this->helpful_count > $this->unhelpful_count;
    }

    /**
     * Lấy tỷ lệ hữu ích
     */
    public function getHelpfulPercentageAttribute()
    {
        $total = $this->helpful_count + $this->unhelpful_count;
        if ($total === 0) {
            return 0;
        }
        
        return round(($this->helpful_count / $total) * 100);
    }

    /**
     * Lấy tổng số vote
     */
    public function getTotalVotesAttribute()
    {
        return $this->helpful_count + $this->unhelpful_count;
    }

    /**
     * Kiểm tra có thể hiển thị công khai không
     */
    public function canBePublic()
    {
        return $this->is_approved && !$this->is_hidden;
    }

    /**
     * Lấy avatar của user (nếu có)
     */
    public function getUserAvatarAttribute()
    {
        // Có thể implement logic avatar sau
        return null;
    }

    /**
     * Lấy tên hiển thị của user
     */
    public function getUserDisplayNameAttribute()
    {
        if (!$this->user) {
            return 'Khách hàng';
        }

        // Ẩn một phần tên để bảo mật
        $name = $this->user->name;
        if (strlen($name) > 2) {
            return substr($name, 0, 1) . str_repeat('*', strlen($name) - 2) . substr($name, -1);
        }
        
        return $name;
    }

    /**
     * Lấy danh sách ưu điểm an toàn
     */
    public function getSafeProsAttribute()
    {
        if (!is_array($this->pros) || empty($this->pros)) {
            return [];
        }
        return $this->pros;
    }

    /**
     * Lấy danh sách nhược điểm an toàn
     */
    public function getSafeConsAttribute()
    {
        if (!is_array($this->cons) || empty($this->cons)) {
            return [];
        }
        return $this->cons;
    }

    /**
     * Kiểm tra có ưu điểm không
     */
    public function hasPros()
    {
        return is_array($this->pros) && !empty($this->pros);
    }

    /**
     * Kiểm tra có nhược điểm không  
     */
    public function hasCons()
    {
        return is_array($this->cons) && !empty($this->cons);
    }
}