<?php

use App\Livewire\Movie;
use App\Livewire\MoviesList;
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

Route::get('/', MoviesList::class)->name('home');
Route::get('/films', MoviesList::class)->name('movieslist');
Route::get('/films/{id}', Movie::class)->name('movie')->where('id', '[0-9]+');
