<?php

use App\Http\Livewire\Events;
use App\Http\Livewire\Airlines;
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
    Route::get('events', Events::class)->name('events');
    Route::get('airlines', Airlines::class)->name('airlines');
    Route::get('flashcards', Flashcards::class)->name('flashcards');
});