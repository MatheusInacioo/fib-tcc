<?php

namespace App\Enums;

enum FinanceGroupByEnum: int
{
    /** Últimos 30 dias */
    case LAST_30_DAYS = 1;
    /** Últimos 6 meses */
    case LAST_6_MONTHS = 2;
    /** Últimos 12 meses */
    case LAST_12_MONTHS = 3;
    /** Período personalizado */
    case CUSTOM_RANGE = 4;
}
