<?php

namespace App\Enums;

enum TransactionRequestType: int
{
    case Deposit = 0;
    case Withdrawal = 1;
    case InternalTransfer = 2;
    case Robot = 3;

    public function getName(): string
    {
        return match ($this) {
            self::Deposit => 'إيداع',
            self::Withdrawal => 'سحب',
            self::InternalTransfer => 'تحويل داخلي',
            self::Robot => 'طلب روبوت',
        };
    }
}
