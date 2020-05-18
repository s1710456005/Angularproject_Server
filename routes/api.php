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

/* authentification */
Route::group ([ 'middleware' => [ 'api' , 'cors']], function () {
    Route::post ( 'auth/login' , 'Auth\ApiAuthController@login' );
});
Route::group ([ 'middleware' => [ 'api' , 'cors', 'jwt.auth' ]], function () {
    Route::post ( 'auth/logout' , 'Auth\ApiAuthController@login' );
    Route::post('shoppinglist', 'ShoppinglistController@save');
    Route::put( 'shoppinglist/{id}' , 'ShoppinglistController@update' );
    Route::delete( 'shoppinglist/{id}' , 'ShoppinglistController@delete' );
    //route to get all shoppinglists for overview and detail
    Route::get('shoppinglists', 'ShoppinglistController@index');
    Route::get('shoppinglist/{id}', 'ShoppinglistController@findById');
    Route::get('shoppinglists/{id}', 'ShoppinglistController@findById');
    Route::get('itemunits', 'ShoppinglistController@getAllUnits');
});