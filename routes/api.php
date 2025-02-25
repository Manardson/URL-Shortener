<?php

use App\Http\Controllers\URLShortenerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/encode', [URLShortenerController::class, 'encode']);
Route::post('/decode', [URLShortenerController::class, 'decode']);
