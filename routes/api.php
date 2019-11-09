<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'AuthController@register')
    ->name('users.register');
Route::post('/login', 'AuthController@login')
    ->name('users.login');

Route::middleware('auth:api')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/profile', 'UserController@show')
            ->name('users.show');

        Route::put('/profile', 'UserController@update')
            ->name('users.update');
    });

    Route::prefix('locations')->group(function () {
        Route::get('/', 'LocationController@index')
            ->name('locations.index');

        Route::post('/', 'LocationController@create')
            ->name('locations.create')
            ->middleware('business');

        Route::get('/{id}', 'LocationController@show')
            ->name('locations.show')
            ->middleware('business');

        Route::put('/{id}', 'LocationController@update')
            ->name('locations.update')
            ->middleware('business');

        Route::delete('/{id}', 'LocationController@delete')
            ->name('locations.delete')
            ->middleware('business');
    });

    Route::prefix('cars')->group(function () {
        Route::get('/', 'CarController@index')
            ->name('cars.index');

        Route::post('/', 'CarController@create')
            ->name('cars.create')
            ->middleware('business');

        Route::get('/{id}', 'CarController@show')
            ->name('cars.show')
            ->middleware('business');

        Route::put('/{id}', 'CarController@update')
            ->name('cars.update')
            ->middleware('business');

        Route::delete('/{id}', 'CarController@delete')
            ->name('cars.delete')
            ->middleware('business');
    });

    Route::prefix('rents')->group(function () {
        Route::get('/', 'RentController@index')
            ->name('rents.index');

        Route::post('/', 'RentController@create')
            ->name('rents.create')
            ->middleware('customer');
    });
});
