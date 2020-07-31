<?php


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
Route::get('me', 'User\MeController@getMe');

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout','Auth\LoginController@logout');
    Route::get('search', 'Admin\User\UserController@search');

    //Users
    Route::get('users', 'Admin\User\UserController@index');
    Route::get('{id}/user', 'Admin\User\UserController@show');
    Route::put('{users}/user', 'Admin\User\UserController@update');
});

Route::group(['middleware' => ['guest:api']], function(){
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Admin\User\RegisterController@register');
});
