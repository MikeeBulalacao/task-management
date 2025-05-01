<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', fn () => redirect('/register'));

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', 'ProfileController@edit')->name('profile.edit');
    Route::patch('/profile', 'ProfileController@update')->name('profile.update');
    Route::delete('/profile', 'ProfileController@destroy')->name('profile.destroy');

    Route::post('logout', 'Auth\AuthenticatedSessionController@destroy')->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('register', 'Auth\RegisteredUserController@create')->name('register');
    Route::get('login', 'Auth\AuthenticatedSessionController@create')->name('login');
    Route::post('login', 'Auth\AuthenticatedSessionController@store');
});

