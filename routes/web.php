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

Route::group(['prefix' => 'site', 'as' => 'site.'], function () {
    Route::get('home', 'Site\SiteController@index')->name('home');
    Route::get('login', 'Site\SiteController@login')->name('login');
    Route::get('resgiter', 'Site\SiteController@signup')->name('resgiter');
});
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Route::get('index', 'Admin\AdminController@index');
    Route::get('manager_customer', 'Admin\AdminController@manager_customer');
    Route::get('manager_booking', 'Admin\AdminController@manager_booking');
    Route::get('profile', 'Admin\AdminController@profile');
});
Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('profile', 'User\UserController@profile');
});


