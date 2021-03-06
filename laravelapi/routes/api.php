<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'LogRegisterController@login');
Route::post('register', 'LogRegisterController@register');


Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
    Route::get('/price', 'PriceController@index');
    Route::post('/price', 'PriceController@create');
    Route::post('/price/update', 'PriceController@update');
    Route::post('/price/delete', 'PriceController@destroy');
    });

