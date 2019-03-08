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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/stock_buy','HomeController@stock_buy_form')->middleware('auth');

Route::post('/timeconv','HomeController@time_convert')->middleware('auth');

Route::post('/create_stock','HomeController@create_stock');


Route::get('/guzzle','HomeController@get_time');

Route::get('/stock_chart/{name}','HomeController@stock_chart')->name('stock_chart');
Route::post('/stock_chart2','HomeController@stock_chart2')->name('stock_chart2');

Route::post('/create_forex','HomeController@create_forex');

Route::get('/forex_buy','HomeController@forex_buy_form')->middleware('auth');

Route::get('/forex_home','HomeController@forex_home');

Route::get('/forex_chart/{name}','HomeController@forex_chart')->name('forex_chart');