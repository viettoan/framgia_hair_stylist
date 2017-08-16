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
}
