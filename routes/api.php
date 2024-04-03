<?php

use App\Http\Controllers\GamesController;
use Illuminate\Support\Facades\Route;

Route::post('/game/create', [GamesController::class, 'store'])->withoutMiddleware('validateCsrfTokens');

