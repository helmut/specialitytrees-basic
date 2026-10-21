<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Trees\SearchController;
use App\Http\Controllers\Trees\TreeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/trees', [SearchController::class, 'index'])->name('trees.index');
Route::get('/trees/{slug}', [TreeController::class, 'show'])->name('trees.show');
