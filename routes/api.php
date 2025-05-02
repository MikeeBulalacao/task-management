<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::post('register', 'Auth\RegisteredUserController@store');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/task', 'TaskController@create');
    Route::patch('/task/{id}', 'TaskController@update');
    Route::get('/task', 'TaskController@list');
    Route::delete('/task/{id}', 'TaskController@delete');
});
