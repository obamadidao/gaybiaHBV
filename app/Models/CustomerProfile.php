<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CustomerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'date_of_birth',
        'gender',
        'avatar',
        'address',
        'city',
        'district',
        'ward',
        'postal_code',
        'country',
        'notes',
        'preferences',
        'is_verified',
        'verified_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'preferences' => 'array',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Relationship với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor để lấy tên đầy đủ
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => trim($this->first_name . ' ' . $this->last_name) ?: $this->user->name,
        );
    }

    /**
     * Accessor để lấy địa chỉ đầy đủ
     */
    protected function fullAddress(): Attribute
    {
        return Attribute::make(
            get: function () {
                $parts = array_filter([
                    $this->address,
                    $this->ward,
                    $this->district,
                    $this->city,
                    $this->country,
                ]);
                return implode(', ', $parts);
            }
        );
    }

    /**
     * Kiểm tra profile đã hoàn thiện chưa
     */
    public function isComplete(): bool
    {
        return !empty($this->first_name) && 
               !empty($this->last_name) && 
               !empty($this->phone) && 
               !empty($this->address);
    }

    /**
     * Lấy phần trám hoàn thiện profile
     */
    public function getCompletionPercentage(): int
    {
        $fields = [
            'first_name', 'last_name', 'phone', 'date_of_birth',
            'gender', 'address', 'city', 'district'
        ];
        
        $completedFields = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }
        
        return round(($completedFields / count($fields)) * 100);
    }
}