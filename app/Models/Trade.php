<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket',
        'symbol',
        'is_demo',
        'type',
        'lot_size',
        'open_price',
        'close_price',
        'take_profit',
        'stop_loss',
        'pnl',
        'is_active',
        'closed_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_demo' => 'boolean',
        'closed_at' => 'datetime',
        'lot_size' => 'decimal:2',
        'open_price' => 'decimal:8',
        'close_price' => 'decimal:8',
        'take_profit' => 'decimal:8',
        'stop_loss' => 'decimal:8',
        'pnl' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
