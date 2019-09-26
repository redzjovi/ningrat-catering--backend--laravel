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

Route::post('/auth/forgot-password')->uses('Api\Auth\ForgotPasswordController@store');
Route::post('/auth/login')->uses('Api\Auth\LoginController@store');
Route::post('/auth/logout')->middleware('auth:api')->uses('Api\Auth\LogoutController@store');
Route::post('/auth/register')->uses('Api\Auth\RegisterController@store');
Route::post('/auth/social/login')->uses('Api\Auth\Social\LoginController@store');
Route::get('/auth/user')->middleware('auth:api')->uses('Api\Auth\UserController@index');
Route::post('/auth/user/change-password')->middleware('auth:api')->uses('Api\Auth\User\ChangePasswordController@store');
Route::get('/product')->uses('Api\ProductController@index');
Route::post('/product')->uses('Api\ProductController@store');
Route::get('/product/{id}')->uses('Api\ProductController@show');
Route::put('/product/{id}')->uses('Api\ProductController@update');
Route::delete('/product/{id}')->uses('Api\ProductController@destroy');
