<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data, $message = '', $meta = [], $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => $meta
        ], $code);
    }

    protected function errorResponse($message = '', $code = 400, $errors = [])
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}