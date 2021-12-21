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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('/user')->group(function()
    {
        Route::post('/login', 'App\Http\Controllers\loginController@login');
        Route::middleware('auth:api')->get('/all','App\Http\Controllers\UserController@index');
    }
);
Route::POST('/crear_usuario', 'App\Http\Controllers\loginController@crear_usuario');
Route::post('/obtener_pagos', 'App\Http\Controllers\PaymentController@getAllpayments');
Route::post('/delete_register', 'App\Http\Controllers\PaymentController@delete_register');
Route::post('/buscar_usuario', 'App\Http\Controllers\PaymentController@buscar_usuario');
Route::post('/uploadPayment', 'App\Http\Controllers\PaymentController@uploadPayment');

