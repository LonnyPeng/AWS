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

Route::get('/', 'DefaultController@index');

Route::get('/register', function () {
	return view('user.register');
});
Route::post('/do/register', 'UserController@register');

Route::get('/login', function () {
	return view('user.login');
});
Route::post('/do/login', 'UserController@login');

Route::get('/web', function () {
	return view('web.index');
});
Route::post('/do/web', 'WebController@index');