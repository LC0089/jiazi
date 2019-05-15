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
Route::get('passwords','UserController@passwords');
Route::get('pwd','UserController@pwd');
Route::get('jyg','UserController@jyg');
Route::get('lc','UserController@lc');
Route::post('reg','UserController@reg');
Route::get('regi','UserController@regi');
Route::get('login','UserController@login');
Route::post('doLogin','UserController@doLogin');
Route::get('loginToken','UserController@loginToken');

