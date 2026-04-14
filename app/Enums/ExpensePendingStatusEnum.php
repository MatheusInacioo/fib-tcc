<?php

namespace App\Enums;

enum ExpensePendingStatusEnum: int
{
    case SETTLED = 0;
    case PENDING = 1;

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }
}
