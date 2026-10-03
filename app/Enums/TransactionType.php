<?php

namespace App\Enums;

enum TransactionType: int
{
    case Deposit = 0;
    case Withdrawal = 1;
    case Profit = 2;
    case ProfitRefer = 3;
    case InternalTransfer = 4;
    case RobotAllocation = 5;
    case RobotRefund = 6;
    case PlanSubscription = 7;

    public function getName(): string
    {
        return match ($this) {
            self::Deposit => 'إيداع',
            self::Withdrawal => 'سحب',
            self::Profit => 'أرباح الخطة',
            self::ProfitRefer => 'نسبة إحالة',
            self::InternalTransfer => 'تحويل داخلي',
            self::RobotAllocation => 'تخصيص للروبوت',
            self::RobotRefund => 'استرجاع تخصيص الروبوت',
            self::PlanSubscription => 'اشتراك خطة',
        };
    }
}
