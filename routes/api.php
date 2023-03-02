<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Events\Index;
use App\Http\Controllers\Airlines\Show;
use App\Http\Controllers\Airlines\Index as AirlinesIndex;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// TODO AIRLINES

Route::middleware('auth:sanctum')->group(function() {
    Route::get('events', Index::class)->name('events.index');
    Route::get('airlines', AirlinesIndex::class)->name('airlines.index');
    Route::get('airline', Show::class)->name('airline.show');
});

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