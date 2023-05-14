<?php

namespace App\Http\Responses;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

final readonly class ErrorResponse implements Responsable
{
    public function __construct(
        private readonly Int $status,
        public Exception $exception
    ) {}
    
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [
                'error' => [
                    'message' => $this->exception->getMessage(),
                    'type' => $this->exception::class,
                    'code' => $this->status
                ]
            ],
            status: $this->status
        );
    }
}