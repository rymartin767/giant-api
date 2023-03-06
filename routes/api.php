<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Flashcards\IndexController;
use App\Http\Controllers\Events\IndexController as EventsIndexController;
use App\Http\Controllers\Airlines\IndexController as AirlinesIndexController;

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
    Route::get('events', EventsIndexController::class)->name('events.index');
    Route::get('airlines', AirlinesIndexController::class)->name('airlines.index');
    Route::get('flashcards', IndexController::class)->name('flashcards.index');
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