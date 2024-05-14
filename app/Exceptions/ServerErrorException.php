<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class ServerErrorException extends Exception
{
    public function __construct(string $message = 'Server Error', public mixed $data = [], int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }

    public function render(): JsonResponse
    {
        $message = config('app.debug') ? $this->getMessage() : 'Something went wrong';

        return response()->json([
            'message' => $message,
            'status' => 1000,
            'data' => [],
        ], $this->code);
    }
}
