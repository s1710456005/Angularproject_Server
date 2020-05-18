<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//hier verweisen wir auf den controller
Route::get('/', 'ShoppinglistController@index');
//delivers the shoppingslists overview
Route::get('/shoppinglists', 'ShoppinglistController@index');
//delivers the detailview of a list
Route::get('/shoppinglists/{shoppinglist}', 'ShoppinglistController@show');