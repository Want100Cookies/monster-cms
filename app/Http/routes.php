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

Route::controller('auth', 'Auth\AuthController');
Route::controller('password', 'Auth\PasswordController');

Route::get('/panel', 'PanelController@index');
Route::get('/panel/page/create', 'PanelController@create');
Route::get('/panel/page/{slug}/edit', 'PanelController@edit');

Route::any('/', 'PageController@show');
Route::any('{slug}', 'PageController@show')->where('slug', '[a-z0-9-]+');