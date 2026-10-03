<?php

namespace App\Enums;

enum TransactionRequestMethod: int
{
    case USDT_TRC20 = 0;
    case USDT_ERC20 = 1;
    case ShamCash = 2;

    public function getName(): string
    {
        return match ($this) {
            self::USDT_TRC20 => 'USDT TRC-20',
            self::USDT_ERC20 => 'USDT ERC-20',
            self::ShamCash => 'ShamCash',
        };
    }

    public function getWalletTarget(): ?string
    {
        return match ($this) {
            self::USDT_TRC20 => 'trc20',
            self::USDT_ERC20 => 'erc20',
            self::ShamCash => 'shamcash',
        };
    }

    public static function depositMethods(): array
    {
        return [
            self::USDT_TRC20,
            self::USDT_ERC20,
            self::ShamCash,
        ];
    }

    public static function withdrawalMethods(): array
    {
        return [
            self::USDT_TRC20,
            self::USDT_ERC20,
        ];
    }

    public static function depositValues(): array
    {
        return array_map(
            static fn (self $method) => $method->value,
            self::depositMethods(),
        );
    }

    public static function withdrawalValues(): array
    {
        return array_map(
            static fn (self $method) => $method->value,
            self::withdrawalMethods(),
        );
    }
}
