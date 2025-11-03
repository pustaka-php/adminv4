<?php

if (!function_exists('indian_format')) {
    function indian_format($number, $decimals = 2)
    {
        static $fmt = null;

        if ($fmt === null) {
            $fmt = new \NumberFormatter('en_IN', \NumberFormatter::DECIMAL);
            $fmt->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $decimals);
            $fmt->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $decimals);
        }

      return '₹ ' . $fmt->format($number);

    }
}
