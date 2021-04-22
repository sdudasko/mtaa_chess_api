<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!pass
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get("/tournaments", 'App\Http\Controllers\TournamentController@index');

Route::group([
    'namespace' => 'App\Http\Controllers',
], function () {
    // Create for all CRUD
//    Route::apiResource('tournaments', 'TournamentController');

    Route::get('/matches', 'MatchController@index');
    Route::put('/matches', 'MatchController@store')->middleware('auth:api');
    Route::post('/matches/{match}', 'MatchController@update');
    Route::get('/matches/exportToPDF/{match}', 'MatchController@exportToPDF');

    Route::get('/players/tournament/{tournamentId}', 'UserController@index');
    Route::put('/players/{player}', 'UserController@update');
    Route::put('/players', 'UserController@store')->middleware('auth:api');
    Route::post('/players', 'UserController@abc');
    Route::get('/players/{player}', 'UserController@show');

    Route::post('/players/checkPlayerId', 'UserController@checkPlayerId');

    Route::get('/players/{player}/matches', 'UserController@getPlayerGames');
    Route::post('/players/import/storeBulk', 'UserController@storeBulk')->middleware('auth:api');

    Route::get('/players/standings/{tournament_id}/', 'UserController@standings');

    // Tournament routes...
    Route::put('/tournaments', 'TournamentController@store')->middleware('auth:api');
    Route::delete('/tournaments/{id}', 'TournamentController@destroy')->middleware('auth:api');
    Route::post('/tournaments/{id}', 'TournamentController@update')->middleware('auth:api');
    Route::get('/tournaments/{hash}', 'TournamentController@show');
    Route::post('/tournaments/checkTournamentByHash/{hash}', 'TournamentController@checkTournamentByHash');

});

Route::post('/register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logoutApi')->middleware('auth:api');


Route::get('/login', 'App\Http\Controllers\Api\AuthController@loginShow')->name('loginShow');
