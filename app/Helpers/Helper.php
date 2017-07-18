<?php

namespace App\Helpers;

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
}
