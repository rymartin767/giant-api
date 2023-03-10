<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Flashcards\IndexController;
use App\Http\Controllers\Events\IndexController as EventsIndexController;
use App\Http\Controllers\Airlines\IndexController as AirlinesIndexController;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('events', EventsIndexController::class)->name('events.index');
    Route::get('airlines', AirlinesIndexController::class)->name('airlines.index');
    Route::get('flashcards', IndexController::class)->name('airlines.index');
});