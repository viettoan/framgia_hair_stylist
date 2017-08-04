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
    return view('index');
});
Route::group(['prefix' => 'site', 'as' => 'site.'], function () {
    Route::get('home', 'Site\SiteController@index')->name('home');
    Route::get('login', 'Site\SiteController@login')->name('login');
    Route::get('resgiter', 'Site\SiteController@signup')->name('resgiter');
    Route::get('success_booking', 'Site\SiteController@success');
    Route::get('accept', 'Site\SiteController@accept');
    Route::get('profile', 'User\UserController@profile');
});
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('home','Admin\AdminController@home');
    Route::get('manager_customer', 'Admin\AdminController@manager_customer');
    Route::get('manager_booking', 'Admin\AdminController@manager_booking');
    Route::get('manager_department', 'Admin\AdminController@manager_department');
    Route::get('manager_service', 'Admin\AdminController@manager_service')->name('manager_service');
    Route::get('profile', 'Admin\AdminController@profile');
    Route::get('bill', 'Admin\AdminController@bill');
    Route::get('list_bill', 'Admin\AdminController@list_bill');
});

