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

use \Illuminate\Support\Facades\Route;

Route::namespace('Api')->group(function () {
    // 用户注册
    Route::post('user', 'AuthController@register');
    // 发送短信
    Route::post('sms','SmsController@send');
    // 找回密码
    Route::post('reset','AuthController@resetPassword');
    // 发布帖子
//    Route::post('user/')
});