<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticatedTokenController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')
    ->name('api.v1.')
    ->group(function () {

        // Auth Routes.
        Route::post('/login', [AuthenticatedTokenController::class, 'store'])
            ->middleware('guest')
            ->name('login');
        Route::post('/logout', [AuthenticatedTokenController::class, 'destroy'])
            ->middleware('auth:sanctum')
            ->name('logout');

        // Protected routes of authenticated requests.
        Route::middleware(['auth:sanctum'])
            ->group(function () {

                // User routes
                Route::controller(UserController::class)
                    ->name('users.')
                    ->group(function () {
                        Route::get('/users', 'index')->name('index');
                        Route::post('/users', 'store')->name('store');
                        Route::get('/users/{user}', 'show')->name('show');
                        Route::patch('/users/{user}', 'update')->name('update');
                        Route::delete('/users/{user}', 'destroy')->name('destroy');
                    });
            });
    });


