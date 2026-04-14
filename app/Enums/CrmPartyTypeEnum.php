<?php

namespace App\Enums;

enum CrmPartyTypeEnum: int
{
    case CUSTOMER = 0;
    case SUPPLIER = 1;

    public function label(): string
    {
        return match ($this) {
            self::CUSTOMER => 'Cliente',
            self::SUPPLIER => 'Fornecedor',
        };
    }

    public function isCustomer(): bool
    {
        return $this === self::CUSTOMER;
    }
}
