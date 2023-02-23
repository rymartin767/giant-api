<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

final readonly class ErrorResponse implements Responsable
{
    public function __construct(
        private readonly string $message,
        private readonly string $error_type,
        private readonly Int $status
    ) {}
    
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [
                'error' => [
                    'message' => $this->message,
                    'type' => $this->error_type,
                    'code' => $this->status
                ]
            ],
            status: $this->status
        );
    }
}