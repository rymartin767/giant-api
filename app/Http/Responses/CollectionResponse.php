<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Responsable;

final readonly class CollectionResponse implements Responsable
{
    public function __construct(
        private readonly Collection $data,
        private readonly Int $status = 200,
    ) {}
    
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [ 
                'data' => $this->data 
            ],
            status: $this->status
        );
    }
}