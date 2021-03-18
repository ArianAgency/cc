<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
//    error_log('***********');
});

Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin-panel', 'AdminController@home')->name('panel');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/test','test\testController@testView');
    Route::view('/test', 'test.test');

    Route::get('/business', 'businessController@index');
//Route::get('/business','AdminController@main');


    Route::get('/admin-panel/def', 'AdminController@def');

    Route::get('/admin-panel/business', 'AdminController@business');
    Route::post('/admin-panel/business', 'AdminController@businessAction');
    Route::get('/admin-panel/business/{type}', 'AdminController@business_type');
    Route::get('/admin-panel/business/get/{this}', 'AdminController@business_get_this');
    Route::post('/admin-panel/business/new', 'AdminController@business_new');


    Route::get('/admin-panel/user', 'AdminController@user');
    Route::post('/admin-panel/user', 'AdminController@userAction');
    Route::get('/admin-panel/user/{type}', 'AdminController@user_type');
    Route::get('/admin-panel/user/get/{this}', 'AdminController@user_get_this');
    Route::post('/admin-panel/user/new', 'AdminController@user_new');
    Route::get('/admin-panel/user/view/{v}', 'AdminController@show_user_v_view');
    Route::post('/admin-panel/user/action/{this}', 'AdminController@user_do_this_action');

    Route::get('/admin-panel/customer', 'AdminController@customer');
    Route::post('/admin-panel/customer', 'AdminController@customerAction');
    Route::get('/admin-panel/customer/{type}', 'AdminController@customer_type');
    Route::get('/admin-panel/customer/get/{this}', 'AdminController@customer_get_this');
    Route::post('/admin-panel/customer/new/{type}', 'AdminController@customer_new');
    Route::get('/admin-panel/customer/view/{v}', 'AdminController@show_customer_v_view');
    Route::post('/admin-panel/customer/action/{this}', 'AdminController@customer_do_this_action');

    Route::get('/admin-panel/service', 'AdminController@services');
    Route::post('/admin-panel/service', 'AdminController@serviceAction');
    Route::get('/admin-panel/service/{type}', 'AdminController@service_type');
    Route::get('/admin-panel/service/get/{this}', 'AdminController@service_get_this');
    Route::post('/admin-panel/service/new/{type}', 'AdminController@service_new');
    Route::get('/admin-panel/service/view/{v}', 'AdminController@show_service_v_view');
    Route::post('/admin-panel/service/action/{this}', 'AdminController@service_do_this_action');


    Route::get('/admin-panel/xsenses', 'AdminController@xsenses');
    Route::post('/admin-panel/xsens', 'AdminController@xsensAction');
    Route::get('/admin-panel/xsens/{type}', 'AdminController@xsens_type');
    Route::get('/admin-panel/xsens/get/{this}', 'AdminController@xsens_get_this');
    Route::post('/admin-panel/xsens/new', 'AdminController@xsens_new');

    Route::get('/admin-panel/services_xsense', 'AdminController@services_xsense');
    Route::post('/admin-panel/services_xsense', 'AdminController@services_xsenseAction');
    Route::get('/admin-panel/serXsen/{type}', 'AdminController@services_xsense_type');
    Route::get('/admin-panel/serXsen/get/{this}', 'AdminController@services_xsense_get_this');
    Route::post('/admin-panel/serXsen/new', 'AdminController@services_xsense_new');

    Route::get('/admin-panel/purchase/{view}', 'AdminController@purchase');
    Route::get('/admin-panel/purchase/get/{this}', 'AdminController@purchase_get_this');
    Route::get('/admin-panel/purchase/do/{this}', 'AdminController@purchase_do_this');
    Route::post('/admin-panel/purchase/doPurchase', 'AdminController@doPurchase');

    Route::get('/admin-panel/score_convertor/view/{v}', 'AdminController@score_convertor');
    Route::get('/admin-panel/score_convertor/do/{this}', 'AdminController@score_convertor_do_this');
    Route::post('/admin-panel/score_convertor/do/{this}', 'AdminController@score_convertor_do_this');
    Route::get('/admin-panel/score_convertor/get/{this}', 'AdminController@score_convertor_get_this');

    Route::get('/admin-panel/report/view/{v}', 'AdminController@report');
    Route::get('/admin-panel/report/get/{this}', 'AdminController@report_get_this');


    Route::post('/upload/{this}','AdminController@store');
});




