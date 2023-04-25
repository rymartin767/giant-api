<?php

use App\Http\Controllers\AirlineController;

use App\Http\Livewire\Awards;
use App\Http\Livewire\Events;
use App\Http\Livewire\Pilots;
use App\Http\Livewire\Airlines;
use App\Http\Livewire\Articles;
use App\Http\Livewire\Staffings;
use App\Http\Livewire\Flashcards;
use Illuminate\Support\Facades\Route;
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
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
    Route::get('pilots', Pilots::class)->name('pilots');
    Route::get('staffing', Staffings::class)->name('staffing');
});

Route::get('torch', AirlineController::class);