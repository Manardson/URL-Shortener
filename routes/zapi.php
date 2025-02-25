<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\URLShortenerController;

Route::post('/encode', [URLShortenerController::class, 'encode']);
Route::post('/decode', [URLShortenerController::class, 'decode']);
