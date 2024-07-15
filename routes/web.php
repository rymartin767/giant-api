<?php

use App\Livewire\Awards;
use App\Livewire\Charts;
use App\Livewire\Events;
use App\Livewire\Pilots;
use App\Livewire\Airlines;
use App\Livewire\Articles;
use App\Livewire\Dashboard;
use App\Livewire\Staffings;
use App\Livewire\Flashcards;
use App\Livewire\Flashcards\Edit;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Award\JuniorsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Data Management Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('admin')->group(function() {
    Route::get('airlines', Airlines::class)->name('airlines');
    Route::get('articles', Articles::class)->name('articles');
    Route::get('awards', Awards::class)->name('awards');
    Route::get('events', Events::class)->name('events');
    Route::get('flashcards', Flashcards::class)->name('flashcards');
    Route::get('flashcards/{flashcard}/edit', Edit::class)->name('flashcards.edit');
    Route::get('pilots', Pilots::class)->name('pilots');
    Route::get('staffing', Staffings::class)->name('staffing');

    Route::get('charts', Charts::class)->name('charts');
});

Route::get('awards/juniors', JuniorsController::class)->name('api.awards.juniors');
