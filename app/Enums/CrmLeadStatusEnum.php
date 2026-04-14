<?php

namespace App\Enums;

enum CrmLeadStatusEnum: int
{
    case CONTACT = 0;
    case NEGOTIATION = 1;
    case PENDING_SIGNATURE = 2;
    case STANDBY = 3;
    case NO_INTEREST = 4;

    public function label(): string
    {
        return match ($this) {
            self::CONTACT => 'Contato',
            self::NEGOTIATION => 'Negociação',
            self::PENDING_SIGNATURE => 'Assinatura Pendente',
            self::STANDBY => 'Standby',
            self::NO_INTEREST => 'Sem Interesse',
        };
    }
}
