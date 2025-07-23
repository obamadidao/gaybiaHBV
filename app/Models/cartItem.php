<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'session_id',
        'user_id', 
        'product_id',
        'selected_variants',
        'quantity',
        'unit_price',
        'total_price'
    ];

    protected $casts = [
        'selected_variants' => 'array',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Methods
    public function updateTotalPrice(): void
    {
        $this->total_price = $this->unit_price * $this->quantity;
        $this->save();
    }

    public function getVariantDisplayAttribute(): string
    {
        if (!$this->selected_variants) {
            return '';
        }

        $variants = [];
        foreach ($this->selected_variants as $type => $value) {
            $variants[] = "{$type}: {$value}";
        }

        return implode(', ', $variants);
    }

    // Scope methods
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeForGuest($query, $sessionId)
    {
        return $query->whereNull('user_id')->where('session_id', $sessionId);
    }
}