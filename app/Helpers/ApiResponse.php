<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success(string $message = 'OK', mixed $data = [], int $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error(string $message = 'Error', mixed $errors = [], int $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
