<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

final readonly class ChartResponse implements Responsable
{
    public function __construct(
        private readonly array $array,
        private readonly Int $status = 200,
    ) {}
    
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [
                'data' => [
                    $this->array
                ]
            ],
            status: $this->status
        );
    }
}