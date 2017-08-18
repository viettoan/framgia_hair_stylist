<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class Helper
{
    public static function apiFormat($error = false, $data = [], $message = [], $status = '200')
    {
        return [
            'error' => $error,
            'data' => $data,
            'message' => $message,
            'status' => $status,
        ];
    }

    public static function reFormatPaginate(LengthAwarePaginator $paginate)
    {
        $currentPage = $paginate->currentPage();

        return [
            'total' => $paginate->total(),
            'per_page' => $paginate->perPage(),
            'current_page' => $currentPage,
            'next_page' => ($paginate->lastPage() > $currentPage) ? $currentPage + 1 : null,
            'prev_page' => $currentPage - 1 ?: null,
            'data' => $paginate->items(),
        ];
    }

    public static function formatPrice($price)
    {
        return number_format($price, 0, '.', ',');
    }

    public static function getSymbolCurrency()
    {
        $format = new \NumberFormatter('vi_VN', \NumberFormatter::CURRENCY);
        return $format->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
    }

    public static function numberIntegerFormat($number)
    {
        return number_format($number);
    }

    public static function numberFloatFormat($number)
    {
        return number_format($number, 2);
    }
}
