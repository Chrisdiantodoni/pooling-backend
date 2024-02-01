<?php
// app/Helpers/ApiResponse.php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = [], $statusCode = 200, $message = 'Success')
    {
        return response()->json([
            'meta' => [
                'code' => $statusCode,
                'status' => 'OK',
                'message' => $message,
            ],
            'data' => $data,
        ], $statusCode);
    }

    public static function error($error = null, $statusCode = 500, $message = 'Error')
    {
        return response()->json([
            'meta' => [
                'code' => $statusCode,
                'status' => 'Error',
                'message' => $message,
            ],
            'error' => $error,
        ], $statusCode);
    }
}
