<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WalletType;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'balance',
    ];

    protected $casts = [
        'type' => WalletType::class,
        'balance' => 'decimal:6',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedBalanceAttribute(): string
    {
        return formatCurrency($this->balance, '$', 'after');
    }

    public function deposit(float $amount, ?string $description = null): bool
    {
        if ($amount <= 0)
            return false;

        return DB::transaction(function () use ($amount, $description) {
            $wallet = Wallet::lockForUpdate()->find($this->id);

            $wallet->transactions()->create([
                'type' => TransactionType::Deposit->value,
                'amount' => $amount,
                'description' => $description ?? "Deposit $amount $ to wallet successfully",
            ]);

            return true;
        });
    }

    public function withdraw(float $amount, ?string $description = null): bool
    {
        if ($amount <= 0)
            return false;

        return DB::transaction(function () use ($amount, $description) {
            $wallet = Wallet::lockForUpdate()->find($this->id);

            if ($wallet->balance < $amount) {
                return false;
            }

            $wallet->transactions()->create([
                'type' => TransactionType::Withdrawal->value,
                'amount' => $amount,
                'description' => $description ?? "Withdrawal $amount $ from wallet successfully",
            ]);

            return true;
        });
    }

    public function addProfit(float $amount, ?string $description = null): bool
    {
        if ($amount <= 0)
            return false;

        return DB::transaction(function () use ($amount, $description) {
            $wallet = Wallet::lockForUpdate()->find($this->id);

            $wallet->transactions()->create([
                'type' => TransactionType::Profit->value,
                'amount' => $amount,
                'status' => TransactionStatus::Accepted,
                'description' => $description ?? "Profit $amount $ added to your wallet successfully",
            ]);

            return true;
        });
    }

}
