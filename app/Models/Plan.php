<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'profit_rate',
        'min_deposit',
        'max_deposit',
        'duration_days',
        'instant_withdrawal',
        'weekly_support',
        'privet_manger',
        'recommendation',
    ];

    protected $casts = [
        'profit_rate' => 'float',
        'min_deposit' => 'float',
        'max_deposit' => 'float',
        'duration_days' => 'integer',
        'instant_withdrawal' => 'boolean',
        'weekly_support' => 'boolean',
        'privet_manger' => 'boolean',
        'recommendation' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function scopeAccountPlans(Builder $query): Builder
    {
        return $query
            ->where(function (Builder $builder) {
                $builder
                    ->whereRaw('LOWER(name) LIKE ?', ['%start%'])
                    ->orWhereRaw('LOWER(name) LIKE ?', ['%trader%'])
                    ->orWhereRaw('LOWER(name) LIKE ?', ['%trade%']);
            })
            ->orderByRaw("
                CASE
                    WHEN LOWER(name) LIKE '%start%' THEN 1
                    WHEN LOWER(name) LIKE '%trader%' THEN 2
                    WHEN LOWER(name) LIKE '%trade%' THEN 2
                    ELSE 99
                END
            ");
    }

    public function getFormattedProfitRateAttribute(): string
    {
        return formatPercent($this->profit_rate);
    }

    public function isStarterPlan(): bool
    {
        return Str::of($this->name)->lower()->contains(['start', 'starter']);
    }

    public function isTraderPlan(): bool
    {
        return Str::of($this->name)->lower()->contains(['trader', 'trade']);
    }

    public function getDisplayNameAttribute(): string
    {
        return match (true) {
            $this->isStarterPlan() => 'Start',
            $this->isTraderPlan() => 'Trade',
            default => brandText($this->name),
        };
    }

    public function isRobotPlan(): bool
    {
        return Str::of($this->name)->lower()->contains(['robot', 'elite']);
    }

    public function hasUnlimitedMaxDeposit(): bool
    {
        return $this->isRobotPlan();
    }

    public function getDisplayProfitRateAttribute(): string
    {
        return match (true) {
            $this->isStarterPlan() => '9%~22%',
            $this->isTraderPlan() => '22%~49%',
            default => formatPercent($this->profit_rate),
        };
    }

    public function getRiskLabelAttribute(): ?string
    {
        return match (true) {
            $this->isStarterPlan() => '7%',
            $this->isTraderPlan() => '18%',
            default => null,
        };
    }

    public function getDisplayMinDepositAttribute(): string
    {
        return formatCurrency($this->min_deposit);
    }

    public function getDisplayMaxDepositAttribute(): string
    {
        return $this->hasUnlimitedMaxDeposit()
            ? 'غير محدود'
            : formatCurrency($this->max_deposit);
    }

    public function getPayoutIntervalLabelAttribute(): string
    {
        return match ((int) $this->duration_days) {
            7 => 'كل 7 أيام',
            14 => 'كل 14 يومًا',
            30 => 'كل 30 يومًا',
            default => 'كل ' . formatTrimmedNumber($this->duration_days, 0) . ' يوم',
        };
    }

    public function getSubscriberReturnLabelAttribute(): string
    {
        return formatPercent($this->profit_rate) . ' ' . $this->payoutIntervalLabel;
    }

    public function getDepositRangeLabelAttribute(): string
    {
        return $this->displayMinDeposit . ' - ' . $this->displayMaxDeposit;
    }
}
