<?php

use App\Http\Controllers\ClubController;
use Illuminate\Support\Facades\Route;


Route::prefix('clubs')->group(function () {
    Route::get('', [ClubController::class, 'index']);
    Route::get('{club}', [ClubController::class, 'show']);
    Route::get('{club}/playing-music', [ClubController::class, 'playingMusic']);
    Route::post('{club}/change-music', [ClubController::class, 'changeMusic']);
    Route::get('{club}/dancers', [ClubController::class, 'dancers']);
    Route::get('{club}/bar-drinkers', [ClubController::class, 'barDrinkers']);
});


Route::prefix('users')->group(function () {
});

Route::prefix('music')->group(function () {
});
