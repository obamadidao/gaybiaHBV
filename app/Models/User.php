<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relationship với CustomerProfile
     */
    public function customerProfile()
    {
        return $this->hasOne(CustomerProfile::class);
    }

    /**
     * Relationship với Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship với Transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relationship với ProductReviews
     */
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Kiểm tra user có phải là admin không
     */
    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'admin';
    }

    /**
     * Kiểm tra user có phải là customer không
     */
    public function isCustomer(): bool
    {
        return $this->role && $this->role->name === 'customer';
    }

    /**
     * Lấy tên hiển thị (ưu tiên tên từ profile)
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->customerProfile && $this->customerProfile->full_name) {
            return $this->customerProfile->full_name;
        }
        return $this->name;
    }
}
