<?php

namespace App\Enums;

enum TransactionStatus: int
{
    case Pending = 0;
    case Accepted = 1;
    case Canceled = 2;
    case Rejected = 3;

    public function getName(): string
    {
        return match ($this) {
            self::Pending => 'قيد الانتظار',
            self::Accepted => 'مقبول',
            self::Canceled => 'ملغى',
            self::Rejected => 'مرفوض',
        };
    }
}
