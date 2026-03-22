<?php

if (! function_exists('format_money')) {
    /**
     * Format an amount with the configured currency symbol (e.g. BDT ৳).
     */
    function format_money(float|int|string|null $amount): string
    {
        $n = is_numeric($amount) ? (float) $amount : 0.0;
        $symbol = config('currency.symbol', '৳');

        return $symbol.number_format($n, 2);
    }
}
