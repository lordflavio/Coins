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


    Route::match(['get','post'], '/petr4', 'HomeController@petr4')->name('petr4');

    Route::match(['get','post'], '/prediction', 'User\PrevisionController@store')->name('prediction');
    Route::match(['get','post'], '/test', 'HomeController@test')->name('test');
    Route::post('/list/{day}/{coins}/{list}','User\PrevisionController@list')->name('list');

    /*
     * Crypitocoins
     * */
    Route::match(['get','post'], '/btc', 'HomeController@btc')->name('btc');
    Route::match(['get','post'], '/dash', 'HomeController@dash')->name('dash');
    Route::match(['get','post'], '/eth', 'HomeController@eth')->name('eth');
    Route::match(['get','post'], '/ltc', 'HomeController@ltc')->name('ltc');
    Route::match(['get','post'], '/xmr', 'HomeController@xmr')->name('xmr');
    Route::match(['get','post'], '/neo', 'HomeController@neo')->name('neo');
    Route::match(['get','post'], '/waves', 'HomeController@waves')->name('waves');
    Route::match(['get','post'], '/xmr', 'HomeController@xrb')->name('xrb');
    Route::match(['get','post'], '/xmr', 'HomeController@xrp')->name('xrp');
    Route::match(['get','post'], '/xmr', 'HomeController@xvg')->name('xvg');


});


