<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/GroupRoutePermission',"PermissionController@usersRoutePerms")->middleware(['api']);

// UNIVERSAL ROUTES
Route::get('/{resource}', 'UniversalController@all')->middleware(['api']);

Route::get('/{resource}/filter','UniversalController@filter')->middleware(['api']);
Route::post('/{resource}/delete', 'UniversalController@delete')->middleware(['api']);
Route::post('/{resource}/save','UniversalController@save')->middleware(['api']);

Route::get('/{resource}/{id}', 'UniversalController@find')->middleware(['api']);

//Route::prefix("auth")->group(function() {
	Route::post("login", "Auth@login");
//});