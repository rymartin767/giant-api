<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\Award\JuniorsController;
use App\Http\Controllers\Award\UpgradesController;
use App\Http\Controllers\Pilot\StaffingController;
use App\Http\Controllers\Pilot\DomicilesController;
use App\Http\Controllers\Pilot\PilotHistoryController;
use App\Http\Controllers\Pilot\RetirementsListController;
use App\Http\Controllers\Charts\RetirementChartController;

Route::middleware('auth:sanctum')->group(function() {
    // BASE MODELS
    Route::get('airlines', AirlineController::class)->name('api.airlines');
    Route::get('articles', ArticleController::class)->name('api.articles');
    Route::get('awards', AwardController::class)->name('api.awards');
    Route::get('events', EventController::class)->name('api.events');
    Route::get('flashcards', FlashcardController::class)->name('api.airlines');
    Route::get('pilots', PilotController::class)->name('api.pilots');

    // EXTENDED FROM BASE MODELS
    Route::get('awards/upgrades', UpgradesController::class)->name('api.awards.upgrades');
    Route::get('awards/juniors', JuniorsController::class)->name('api.awards.juniors');

    Route::get('pilots/retirements-list', RetirementsListController::class)->name('api.pilots.retirements-list');
    Route::get('pilots/staffing', StaffingController::class)->name('api.pilots.staffing');
    Route::get('pilots/domiciles', DomicilesController::class)->name('api.pilots.domiciles');
    Route::get('pilots/history', PilotHistoryController::class)->name('api.pilots.history');

    // CHARTS
    Route::get('charts/pilots/retirements', RetirementChartController::class)->name('api.charts.retirement');
});