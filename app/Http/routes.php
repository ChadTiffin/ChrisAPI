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

Route::get('/{resource}', 'Controller@all');
Route::get('/{resource}/{id}', 'Controller@find');
Route::post('/{resource}/delete', 'Controller@delete');
Route::post('/{resource}/save','Controller@save');
Route::post('/{resource}/filter','Controller@filter');

