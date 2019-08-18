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

Route::get('/', function () {
    return view('welcome');
});
Route::get('create-chart/{type}','ChartController@makeChart');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}', 'HomeController@index')->where( 'path' , '([A-z\d\-\/_.]+)?' );

//Route::get('{path}','HomeController@index')->where( 'path', '([A-z\d-/_.]+)?' ); not work

