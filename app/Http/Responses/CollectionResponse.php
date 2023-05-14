<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;

final readonly class CollectionResponse implements Responsable
{
    public function __construct(
        private readonly JsonResource $data,
        private readonly Int $status = 200,
    ) {}
    
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: $this->data,
            status: $this->status
        );
    }
}