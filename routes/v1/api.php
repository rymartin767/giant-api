<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Flashcards\IndexController;
use App\Http\Controllers\Events\IndexController as EventsIndexController;
use App\Http\Controllers\Airlines\IndexController as AirlinesIndexController;
use App\Http\Controllers\Articles\IndexController as ArticlesIndexController;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('airlines', AirlinesIndexController::class)->name('airlines.index');
    Route::get('articles', ArticlesIndexController::class)->name('articles.index');
    Route::get('events', EventsIndexController::class)->name('events.index');
    Route::get('flashcards', IndexController::class)->name('airlines.index');
});