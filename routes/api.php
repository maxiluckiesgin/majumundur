<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
// | routes are loaded by the Rouaddleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::get('/product', 'ProductController@index');
        Route::post('/product', 'ProductController@store');
        Route::put('/product/{id}', 'ProductController@update');
        Route::delete('/product/{id}', 'ProductController@destroy');
        Route::post('/buy/{id}', 'TransactionController@store');
        Route::get('/buyerlist', 'TransactionController@buyerList');
    });
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
});

