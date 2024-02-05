<?php
// app/Helpers/ApiResponse.php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = [], $statusCode = 200, $message = 'Success', $page_info = [])
    {
        $response = [
            'meta' => [
                'code' => $statusCode,
                'status' => 'OK',
                'message' => $message,
            ],
            'data' => $data,
        ];


        if (!empty($page_info)) {
            $response['page_info'] = $page_info;
        }
        return response()->json($response, $statusCode);
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
