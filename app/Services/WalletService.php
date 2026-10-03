<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    public function deposit(Wallet $wallet, float $amount, ?string $desc = null): bool
    {
        return $wallet->deposit($amount, $desc);
    }

    public function withdraw(Wallet $wallet, float $amount, ?string $desc = null): bool
    {
        return $wallet->withdraw($amount, $desc);
    }

    public function addProfit(Wallet $wallet, float $amount, ?string $desc = null): bool
    {
        return $wallet->addProfit($amount, $desc);
    }
}
