<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/v0/get-salons', 'Api\DepartmentsController@index');
Route::get('/v0/get-stylist-by-salonId/{id}', 'Api\UserController@getStylistbySalonID');
Route::get('/v0/first_render_booking', 'Api\ApiController@firstRenderBooking');
