<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CopyTradingSetting extends Model
{
    protected $fillable = [
        'user_id',
        'source_account',
        'capital_percentage',
        'risk_level',
        'stop_copy_loss',
        'is_active',
    ];

    protected $casts = [
        'capital_percentage' => 'decimal:2',
        'stop_copy_loss' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
