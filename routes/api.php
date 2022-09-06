<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->controller(\App\Http\Controllers\Api\UserController::class)
    ->group(function () {

        // consume Api and save data
        Route::get('/users/add', 'add');

        Route::get('/users/search', 'search');

        // fetch the data
        Route::group(['middleware' => ['cors', 'apikey']], function () {
            Route::get('/users', 'index');
        });
});
