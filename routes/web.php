<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin-panel','AdminController@home')->name('panel');
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/test','test\testController@testView');
    Route::view('/test','test.test');

    Route::get('/business','businessController@index');
//Route::get('/business','AdminController@main');


    Route::get('/admin-panel/def','AdminController@def');

    Route::get('/admin-panel/business','AdminController@business');
    Route::post('/admin-panel/business','AdminController@businessAction');
    Route::get('/admin-panel/business/{type}','AdminController@business_type');
    Route::get('/admin-panel/business/get/{this}','AdminController@business_get_this');
    Route::post('/admin-panel/business/new','AdminController@business_new');

    Route::get('/admin-panel/user','AdminController@user');
    Route::post('/admin-panel/user','AdminController@userAction');
    Route::get('/admin-panel/user/{type}','AdminController@user_type');
    Route::get('/admin-panel/user/get/{this}','AdminController@user_get_this');
    Route::post('/admin-panel/user/new','AdminController@user_new');

    Route::get('/admin-panel/customer','AdminController@customer');
    Route::post('/admin-panel/customer','AdminController@customerAction');
    Route::get('/admin-panel/customer/{type}','AdminController@customer_type');
    Route::get('/admin-panel/customer/get/{this}','AdminController@customer_get_this');
    Route::post('/admin-panel/customer/new','AdminController@customer_new');

    Route::post('/upload/user-img','AdminController@store');

});




