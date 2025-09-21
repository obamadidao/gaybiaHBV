<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'user_id',
        'subject',
        'message',
        'priority',
        'status',
        'replied_at',
        'replied_by',
        'reply_message',
        'admin_notes',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repliedByAdmin()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', 'high');
    }

    public function scopeMediumPriority($query)
    {
        return $query->where('priority', 'medium');
    }

    public function scopeLowPriority($query)
    {
        return $query->where('priority', 'low');
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Chờ xử lý',
            'in_progress' => 'Đang xử lý',
            'replied' => 'Đã trả lời',
            'closed' => 'Đã đóng',
            default => 'Không xác định'
        };
    }

    public function getPriorityTextAttribute()
    {
        return match($this->priority) {
            'low' => 'Thấp',
            'medium' => 'Trung bình',
            'high' => 'Cao',
            default => 'Trung bình'
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'in_progress' => 'info',
            'replied' => 'success',
            'closed' => 'secondary',
            default => 'secondary'
        };
    }

    public function getPriorityBadgeClassAttribute()
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            default => 'warning'
        };
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function getFormattedRepliedAtAttribute()
    {
        return $this->replied_at ? $this->replied_at->format('d/m/Y H:i') : null;
    }

    // Methods
    public function markAsInProgress($adminId = null)
    {
        $this->update([
            'status' => 'in_progress',
            'replied_by' => $adminId
        ]);
    }

    public function reply($message, $adminId)
    {
        $this->update([
            'status' => 'replied',
            'reply_message' => $message,
            'replied_by' => $adminId,
            'replied_at' => now()
        ]);
    }

    public function close($adminId = null)
    {
        $this->update([
            'status' => 'closed',
            'replied_by' => $adminId ?? $this->replied_by
        ]);
    }

    public function updatePriority($priority)
    {
        $this->update(['priority' => $priority]);
    }

    // Static methods
    public static function getStatistics()
    {
        return [
            'total' => self::count(),
            'pending' => self::pending()->count(),
            'in_progress' => self::inProgress()->count(),
            'replied' => self::replied()->count(),
            'closed' => self::closed()->count(),
            'high_priority' => self::highPriority()->count(),
            'today' => self::whereDate('created_at', today())->count(),
            'this_week' => self::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
        ];
    }

    // Validation rules
    public static function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'priority' => 'nullable|in:low,medium,high'
        ];
    }

    public static function getAdminValidationRules()
    {
        return [
            'status' => 'required|in:pending,in_progress,replied,closed',
            'priority' => 'required|in:low,medium,high',
            'reply_message' => 'nullable|string',
            'admin_notes' => 'nullable|string'
        ];
    }
}