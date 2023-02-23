<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

final readonly class EmptyResponse implements Responsable
{
    public function __construct(
        private readonly Int $status = 200,
    ) {}
    
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [
                'data' => []
            ],
            status: $this->status
        );
    }
}