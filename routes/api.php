<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')
    ->name('api.v1.')
    ->group(function () {

        // Protected routes of authenticated requests.
        Route::middleware(['auth:sanctum'])
            ->group(function () {

                // User routes
                Route::controller(UserController::class)
                    ->group(function () {
                        Route::get('/users', 'index');
                        Route::post('/users', 'store');
                        Route::get('/users/{user}', 'show');
                        Route::put('/users/{user}', 'update');
                        Route::delete('/users/{user}', 'destroy');
                    });
            });
    });


