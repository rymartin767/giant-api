<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Responsable;

final readonly class ModelResponse implements Responsable
{
    public function __construct(
        private readonly Model $model,
        private readonly Int $status = 200,
    ) {}
    
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: [
                'data' => $this->model
            ],
            status: $this->status
        );
    }
}