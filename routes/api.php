<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
Route::group(['prefix' => 'restaurants', 'as' => 'restaurant.', 'namespace' => 'Api'], function () {


    Route::post('/{restaurant_id}/update', 'RestaurantController@update')->name('update');

    Route::get('/create', 'RestaurantController@create');
    Route::get('/get-url', 'RestaurantController@getUrl');
    Route::post('/parsing', 'RestaurantController@parsing');
    Route::get('/list', 'RestaurantController@list');


});
Route::group(['prefix' => 'orders', 'as' => 'order.', 'namespace' => 'Api'], function () {
    Route::get('/list', 'OrderController@list');
});

Route::group(['prefix' => 'bills', 'as' => 'bill.','namespace' =>'Api'], function (){
    Route::post('/create', 'BillController@create');
});

Route::middleware('auth:api')->post('/logout', [ AuthController::class, 'logout' ]);

Route::post('/login', [ AuthController::class, 'login' ]);
Route::post('/register', [ AuthController::class, 'register' ]);