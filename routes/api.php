<?php

use Illuminate\Http\Request;
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


Route::get('weather/{city}', 'Weather\WeatherController@index');
Route::get('history/{city}', 'Weather\WeatherHistoryController@index');
// Route::resource('weather', 'Wather\WatherController')->only(['index']);