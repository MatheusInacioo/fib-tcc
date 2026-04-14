<?php

namespace App\Enums;

enum TransactionTypeEnum: int
{
    case PURCHASE = 0;
    case SALE = 1;

    public function label(): string
    {
        return match ($this) {
            self::PURCHASE => 'Compra',
            self::SALE => 'Venda',
        };
    }

    public function isPurchase(): bool
    {
        return $this === self::PURCHASE;
    }

    public function isSale(): bool
    {
        return $this === self::SALE;
    }
}
