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
Route::group(['prefix' => 'restaurants', 'as' => 'restaurant.', 'namespace' => 'Api'], function() {

    Route::group(['prefix' => '{restaurants}', 'as' => 'restaurant.'], function() {
        Route::post('update', 'RestaurantController@update')->name('update');
    });

    Route::get('/send-url', 'RestaurantController@sendUrl');
    Route::get('/get-url', 'RestaurantController@getUrl');
    Route::post('/parsing', 'RestaurantController@parsing');
    Route::get('/list', 'RestaurantController@list');


});
