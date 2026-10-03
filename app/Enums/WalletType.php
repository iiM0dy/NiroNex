<?php

namespace App\Enums;

enum WalletType: int
{
    case Deposit = 0;
    case Profit = 1;

    public function getName(): string
    {
        return match ($this) {
            self::Deposit => 'إيداع',
            self::Profit => 'أرباح',
        };
    }
}
