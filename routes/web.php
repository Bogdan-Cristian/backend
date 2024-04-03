<?php

use App\Http\Controllers\GamesController;
use App\Http\Controllers\ImporterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/games', [GamesController::class, 'index']);
Route::get('/import', [ImporterController::class, 'import']);
