<?php

namespace App\Models;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Enums\WalletType;
use App\Traits\HasStorageUrl;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasStorageUrl;

    protected $appends = ['is_admin', 'full_name', 'balance', 'deposit_balance', 'profit_balance'];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'withdrawal_address',
        'address',
        'birthday',
        'image',
        'id_photo_type',
        'id_photo_front',
        'id_photo_back',
        'selfie_photo',
        'type',
        'status',
        'plan_id',
        'plan_amount',
        'last_profit_date',
        'referrer_id',
        'trading_balance',
        'is_demo',
        'demo_trading_balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birthday' => 'date:Y-m-d',
        'last_profit_date' => 'datetime',
        'type' => UserType::class,
        'status' => UserStatus::class,
        'plan_amount' => 'decimal:2',
        'trading_balance' => 'decimal:2',
        'demo_trading_balance' => 'decimal:2',
        'is_demo' => 'boolean',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function depositWallet(): HasOne
    {
        return $this->hasOne(Wallet::class)->where('type', WalletType::Deposit);
    }

    public function profitWallet(): HasOne
    {
        return $this->hasOne(Wallet::class)->where('type', WalletType::Profit);
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->type == UserType::Admin;
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getBalanceAttribute(): float
    {
        return $this->wallets->sum('balance');
    }

    public function getDepositBalanceAttribute(): float
    {
        return $this->wallets->where('type', WalletType::Deposit->value)->sum('balance');
    }

    public function getProfitBalanceAttribute(): float
    {
        return $this->wallets->where('type', WalletType::Profit->value)->sum('balance');
    }

    public function getBirthdayAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Wallet::class);
    }

    public function requests(): hasMany
    {
        return $this->hasMany(TransactionRequest::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referrer_id');
    }

    public function referralEarnings(): HasMany
    {
        return $this->hasMany(ReferralEarning::class, 'referrer_id');
    }

    public function earnedFromMe(): HasMany
    {
        return $this->hasMany(ReferralEarning::class, 'referred_id');
    }

    public function getReferralLinkAttribute(): string
    {
        return route('register', ['ref' => $this->id]);
    }

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }
    public function copyTradingSetting(): HasOne
    {
        return $this->hasOne(CopyTradingSetting::class);
    }



    public function robotSettings(): HasOne
    {
        return $this->hasOne(RobotSetting::class);
    }

    public function robotSetting(): HasOne
    {
        return $this->robotSettings();
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function hasCompletedKyc(): bool
    {
        return !empty($this->id_photo_front)
            && !in_array($this->status, [UserStatus::Pending, UserStatus::Inactive], true);
    }

    public function hasRobotAccess(): bool
    {
        return (bool) $this->plan?->isRobotPlan();
    }

    public function isDemoAccount(): bool
    {
        return (bool) $this->is_demo;
    }

    public function scopeNotDemo(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('is_demo', false)->orWhereNull('is_demo');
        })
            ->where('email', 'not like', 'demo\_%')
            ->where('email', 'not like', 'demo@%')
            ->where('email', 'not like', '%@pipix.%')
            ->where('email', 'not like', '%@lira.%')
            ->where(function (Builder $q) {
                $q->whereNull('first_name')
                    ->orWhereRaw('LOWER(first_name) != ?', ['demo']);
            });
    }

    public function scopeRealUsers(Builder $query): Builder
    {
        return $query->where('type', UserType::User)->notDemo();
    }

}
