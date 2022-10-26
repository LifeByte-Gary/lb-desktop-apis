<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')
    ->name('api.v1.')
    ->group(function () {

        // Protected routes of authenticated requests.
        Route::middleware(['auth:sanctum'])
            ->group(function () {

                // User routes
                Route::controller(UserController::class)
                    ->name('users.')
                    ->group(function () {
                        Route::get('/users', 'index')
                            ->can('viewAny', User::class)
                            ->name('index');
                        Route::post('/users', 'store')
                            ->name('store');
                        Route::get('/users/{user}', 'show')
                            ->can('view', 'user')
                            ->name('show');
                        Route::put('/users/{user}', 'update')
                            ->name('update');
                        Route::delete('/users/{user}', 'destroy')
                            ->name('destroy');
                    });
            });
    });


