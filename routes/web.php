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


Route::group(['prefix' => 'auth'], function () {
    Route::get('logout', 'UserController@logout');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return redirect('/login');
    });
    Auth::routes();
});

Route::group(['middleware' => 'auth'], function () {
    Route::any('{all}', 'SpaController@index')->where('any', '.*');
});
