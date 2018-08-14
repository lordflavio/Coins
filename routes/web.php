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

Route::group(['middleware' => ['auth']], function() {

    Route::match(['get','post'], '/perfil', 'User\ClientController@perfil')->name('perfil');

    Route::match(['get','post'], '/dolar', 'HomeController@dolar')->name('dolar');
    Route::match(['get','post'], '/euro', 'HomeController@euro')->name('euro');
    Route::match(['get','post'], '/libra', 'HomeController@libra')->name('libra');
    Route::match(['get','post'], '/bitcoin', 'HomeController@bitcoin')->name('bitcoin');
    Route::match(['get','post'], '/prediction', 'User\PrevisionController@store')->name('prediction');
    Route::match(['get','post'], '/prediction/{coins}', 'User\PrevisionController@refresh')->name('refresh');
    Route::match(['get','post'], '/test', 'HomeController@test')->name('test');

});


