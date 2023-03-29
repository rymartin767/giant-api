<?php

use App\Http\Controllers\AirlineController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\PilotController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {
    Route::get('airlines', AirlineController::class)->name('api.airlines');
    Route::get('articles', ArticleController::class)->name('api.articles');
    Route::get('events', EventController::class)->name('api.events');
    Route::get('flashcards', FlashcardController::class)->name('api.airlines');
    Route::get('pilots', PilotController::class)->name('api.pilots');
    Route::get('employee', EmployeeController::class)->name('api.employee');
});