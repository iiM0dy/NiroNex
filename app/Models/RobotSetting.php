<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RobotSetting extends Model
{
    protected $fillable = [
        'user_id',
        'risk_level',
        'take_profit',
        'stop_loss',
        'trade_duration',
        'is_active',
        'wallet_percentage',
        'pep_price',
        'allocation_amount',
        'status',
        'transaction_request_id',
        'allocation_transaction_id',
        'refund_transaction_id',
    ];

    protected $casts = [
        'take_profit' => 'decimal:2',
        'stop_loss' => 'decimal:2',
        'wallet_percentage' => 'decimal:2',
        'pep_price' => 'decimal:2',
        'allocation_amount' => 'decimal:6',
        'is_active' => 'boolean',
        'status' => TransactionStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRiskLabelAttribute(): string
    {
        return match ($this->risk_level) {
            'low' => 'منخفض',
            'medium' => 'متوسط',
            'high' => 'مرتفع',
            default => $this->risk_level,
        };
    }

    public function getDurationLabelAttribute(): string
    {
        return match ($this->trade_duration) {
            'weekly' => 'أسبوعي',
            'biweekly' => 'نصف شهري',
            'monthly' => 'شهري',
            default => $this->trade_duration,
        };
    }

    public function getPepPriceLabelAttribute(): string
    {
        return '$' . formatTrimmedNumber($this->pep_price, 2);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            TransactionStatus::Accepted => 'مقبول',
            TransactionStatus::Rejected => 'مرفوض',
            TransactionStatus::Canceled => 'ملغى',
            default => 'قيد المراجعة',
        };
    }
}
