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

    Route::put('/matches', 'MatchController@store');
    Route::get('/matches', 'MatchController@index');
    Route::post('/matches/{match}', 'MatchController@update');
    Route::get('/matches/exportToPDF/{match}', 'MatchController@exportToPDF');

});
