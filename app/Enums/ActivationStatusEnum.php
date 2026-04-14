<?php

namespace App\Enums;

enum ActivationStatusEnum: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }
}
