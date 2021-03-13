<?php

use Illuminate\Support\Facades\Route;


//Route::get('/pos-panel', function () {
//    return view('welcome');
//});



Route::group(['prefix'=>'pos-panel'],function(){
    Route::group(['middleware' => ['auth']], function () {
        Route::get('dashboard', 'PosPanelController@dashboard');
        Route::get('logout', 'PosPanelController@logout')->name('pos-logout');

        Route::get('/view/{v}', 'PosPanelController@show_pos_v_view');
        Route::get('/get/{this}', 'PosPanelController@pos_get_this');
        Route::post('/do/{type}', 'PosPanelController@do_action');
        Route::get('/testTable/get/{this}', 'PosPanelController@pos_get_this');
        Route::get('/testTable/do/{this}', 'PosPanelController@purchase_do_this');
        Route::post('/purchase/doPurchase', 'PosPanelController@doPurchase');
    });
    Route::get('login', 'PosPanelController@index')->name('pos-login');
    Route::post('post-login', 'PosPanelController@postLogin');
    Route::get('registration', 'PosPanelController@registration');
    Route::post('post-registration', 'PosPanelController@postRegistration');

});


