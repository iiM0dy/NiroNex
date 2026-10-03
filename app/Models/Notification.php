<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'body',
        'data',
        'is_read',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: unread notifications only.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Get the icon class based on notification type.
     */
    public function getIconAttribute(): string
    {
        return match ($this->type) {
            'trade_closed' => 'fa-chart-line',
            'robot_status' => 'fa-robot',
            'withdrawal' => 'fa-money-bill-transfer',
            default => 'fa-bell',
        };
    }

    /**
     * Get the tone/color class based on notification type.
     */
    public function getToneAttribute(): string
    {
        return match ($this->type) {
            'trade_closed' => 'is-trade',
            'robot_status' => 'is-robot',
            'withdrawal' => 'is-withdrawal',
            default => 'is-neutral',
        };
    }
}
