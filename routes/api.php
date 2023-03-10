<?php

// Version 1

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('v1:')->group(
    base_path('routes/v1/api.php')
);

// ! ROUTE NOT FOUND
Route::fallback(function(){
    return response()->json([
        'error' => [
            'message' => 'Route Not Found',
            'type' => 'Symfony\Component\Routing\Exception\RouteNotFoundException',
            'code' => 404
        ]
    ], 404);
});