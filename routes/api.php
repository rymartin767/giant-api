<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Events\Index;

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

// TODO EVENTS

Route::middleware('auth:sanctum')->group(function() {
    Route::get('events', Index::class)->name('events.index');
});

// ! ROUTE NOT FOUND
Route::fallback(function(){
    return response()->json([
        'error' => [
            'message' => 'Route Not Found',
            'type' => 'RouteException',
            'code' => 404
        ]
    ], 404);
});