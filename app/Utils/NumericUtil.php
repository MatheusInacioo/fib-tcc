<?php

namespace App\Utils;

class NumericUtil {
    public static function formatToCurrency(float $value, string $currency)
    {
        return $currency . number_format($value, 2, ',', '.');
    }

    public static function getProfitMarginValue(float $invoicing, float $grossProfit)
    {
        return $invoicing > 0 ? round(($grossProfit / $invoicing) * 100, 2) . '%' : 0;
    }
}