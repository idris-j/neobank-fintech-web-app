<?php

namespace App\Traits;


trait ApiResponse
{
    public function withSuccess($msg): array
    {
        return [
            'status' => 'success',
            'message' => $msg
        ];
    }

    public function withError($msg): array
    {
        return [
            'status' => 'error',
            'message' => $msg
        ];
    }
}
