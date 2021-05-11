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

Route::middleware('auth:api')->get('/user', function (Request $request) {return $request->user();});
Route::post('login', '\App\Http\Controllers\Api\Auth\LoginController@login');
Route::post('get', '\App\Http\Controllers\Api\VplayController@get');
Route::post('getring', '\App\Http\Controllers\Api\VplayController@getring');
Route::post('setring', '\App\Http\Controllers\Api\VplayController@setring');
Route::post('delring', '\App\Http\Controllers\Api\VplayController@delring');

Route::post('addupload', '\App\Http\Controllers\Api\VplayController@addupload');
Route::post('getupload', '\App\Http\Controllers\Api\VplayController@getupload');
Route::post('delupload', '\App\Http\Controllers\Api\VplayController@delupload');
