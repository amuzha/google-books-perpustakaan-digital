<?php

use Carbon\Carbon;

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        try {
            if (preg_match('/^\d{4}$/', $date)) {
                return Carbon::createFromFormat('Y', $date)->startOfYear()->toDateString();
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return $date;
            } else {
                return Carbon::parse($date)->toDateString();
            }
        } catch (Exception $e) {
            return null;
        }
    }
}

if (!function_exists('setActive')) {
    function setActive($route, $output = 'active')
    {
        return request()->routeIs($route) ? $output : '';
    }
}

if (!function_exists('truncateText')) {
    function truncateText($text, $maxLength = 100) {
        if (strlen($text) <= $maxLength) {
            return $text;
        }

        return substr($text, 0, $maxLength) . '...';
    }
}

if (!function_exists('formatPrice')) {
    function formatPrice($price, $currencySymbol = 'Rp. ', $decimalSeparator = ',', $thousandSeparator = '.')
    {
        if ($price <= 0 || is_null($price)) {
            return 'Free';
        }

        return $currencySymbol . number_format($price, 2, $decimalSeparator, $thousandSeparator);
    }
}
