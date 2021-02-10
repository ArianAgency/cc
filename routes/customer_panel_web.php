<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


//Route::get('/customer-panel', function () {
//    return view('welcome');
//});



Route::group(['prefix'=>'customer-panel'],function(){

    Route::get('login', 'CustomerPanelController@index');
    Route::post('post-login', 'CustomerPanelController@postLogin');
    Route::get('registration', 'CustomerPanelController@registration');
    Route::post('post-registration', 'CustomerPanelController@postRegistration');
    Route::get('dashboard', 'CustomerPanelController@dashboard')->name('customer-dashboard');
    Route::get('logout', 'CustomerPanelController@logout');

    Route::get('/view/{v}', 'CustomerPanelController@show_customer_v_view');
    Route::post('/do/{type}', 'CustomerPanelController@do_action');

    Route::get('/testTable/get/{this}', 'CustomerPanelController@customer_get_this');
    Route::get('/testTable/do/{this}', 'CustomerPanelController@purchase_do_this');



});


