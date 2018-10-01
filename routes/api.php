<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController as ProductController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
// | routes are loaded by the Rouaddleware group. Enjoy building your API!
|
*/
Route::post('/register','UserController@register');
Route::get('/product', 'ProductController@index');
Route::post('/product', 'ProductController@store');
Route::put('/product/{id}','ProductController@update');
Route::delete('/product/{id}','ProductController@destroy');
Route::post('/buy/{id}','TransactionController@store');
Route::post('/buyerlist','TransactionController@buyerList');

