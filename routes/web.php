<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/random/show/', 'App\Http\Controllers\RandomFactController@showFact')->name('randomfact');
Route::get('/random/private/{id}', 'App\Http\Controllers\RandomFactController@showPrivateFact')->name('randomfact');

Route::get('/randomhistoric/show/{date}', 'App\Http\Controllers\RandomFactController@showHistoricFact')->name('randomfact');
Route::put('/home', 'App\Http\Controllers\RandomFactController@createFact')->name('randomfact');

Route::put('/random/store', 'App\Http\Controllers\RandomFactController@createFact')->name('randomfact');
