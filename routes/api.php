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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get("/tournaments", 'App\Http\Controllers\TournamentController@index');

Route::group([
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::apiResource('tournaments', 'TournamentController');

    Route::put('/matches', 'MatchController@store')->middleware('auth:api');
    Route::get('/matches', 'MatchController@index');
    Route::post('/matches/{match}', 'MatchController@update');
    Route::get('/matches/exportToPDF/{match}', 'MatchController@exportToPDF');

    Route::get('/players', 'UserController@index');
    Route::put('/players', 'UserController@store');
    Route::get('/players/{player}', 'UserController@show');
    Route::get('/players/{player}/matches', 'UserController@getPlayerGames');
    Route::put('/players/{player}', 'UserController@update');
});

Route::post('/register/passport', 'App\Http\Controllers\Api\AuthController@register');
Route::post('/login/passport', 'App\Http\Controllers\Api\AuthController@login');
Route::post('/logout/passport','App\Http\Controllers\Api\AuthController@logoutApi')->middleware('auth:api');


Route::get('/login', 'App\Http\Controllers\Api\AuthController@loginShow')->name('loginShow');