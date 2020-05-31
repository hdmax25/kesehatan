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

Route::get('/', static function () {
  if (Auth::guest()) {
    return redirect()->route('login');
  }
  return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'user', 'as' => 'user.'], static function () {
  Route::get('/', 'UserController@index')->name('index')->middleware('auth', 'role:1');
  Route::get('/create', 'UserController@create')->name('create')->middleware('auth', 'role:1');
  Route::post('/store', 'UserController@store')->name('store')->middleware('auth', 'role:1');
  Route::get('/show/{id}', 'UserController@show')->name('show')->middleware('auth');
  Route::get('/edit/{id}', 'UserController@edit')->name('edit')->middleware('auth', 'role:1');
  Route::post('/update/{id}', 'UserController@update')->name('update')->middleware('auth', 'role:1');
  Route::get('/destroy/{id}', 'UserController@destroy')->name('destroy')->middleware('auth', 'role:1');
});