<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Events\IndexController as EventsIndexController;
use App\Http\Controllers\Pilots\IndexController as PilotsIndexController;
use App\Http\Controllers\Airlines\IndexController as AirlinesIndexController;
use App\Http\Controllers\Articles\IndexController as ArticlesIndexController;
use App\Http\Controllers\Flashcards\IndexController as FlashcardsIndexController;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('airlines', AirlinesIndexController::class)->name('airlines.index');
    Route::get('articles', ArticlesIndexController::class)->name('articles.index');
    Route::get('events', EventsIndexController::class)->name('events.index');
    Route::get('flashcards', FlashcardsIndexController::class)->name('airlines.index');
    Route::get('pilots', PilotsIndexController::class)->name('pilots.index');
});