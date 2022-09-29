<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('games')->group(function () {
        Route::controller(GameController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'create');
            Route::put('{id}', 'update');
            Route::get('{id}', 'show');
            Route::delete('{id}', 'delete');
        });
    });
    Route::prefix('genres')->group(function () {
        Route::controller(GenreController::class)->group(function () {
            Route::get('', 'index');
            Route::post('', 'create');
            Route::put('{id}', 'update');
            Route::get('{id}', 'show');
            Route::delete('{id}', 'delete');
        });
    });
});
