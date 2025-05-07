<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success($data, $message = '', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null,
            'code' => $code
        ], $code);
    }

    protected function error($message, $errors = null, $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors,
            'code' => $code
        ], $code);
    }
}
