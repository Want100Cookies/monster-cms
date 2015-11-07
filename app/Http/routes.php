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

Route::controller(  'auth',                     'Auth\AuthController');
Route::controller(  'password',                 'Auth\PasswordController');

Route::get(         '/panel',                   'PanelController@index');

Route::get(         '/panel/page/create',       'PanelController@create');
Route::post(        '/panel/page/create',       'PanelController@store');

Route::post(        '/panel/block/create',      'PanelController@storeBlock');
Route::post(        '/panel/block/update',      'PanelController@updateBlock');
Route::post(        '/panel/block/get',         'PanelController@getBlock');
Route::post(        '/panel/block/destroy',     'PanelController@destroyBlock');

Route::get(         '/panel/page/{slug}/edit',      'PanelController@edit');
Route::post(        '/panel/page/{slug}/update',    'PanelController@update');

Route::any(         '/',                        'PageController@show');
Route::any(         '{slug}',                   'PageController@show')->where('slug', '[a-z0-9-]+');