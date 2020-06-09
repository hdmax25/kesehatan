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
  Route::post('/update/profile/{id}', 'UserController@updateProfile')->name('updateProfile')->middleware('auth');
  Route::get('/destroy/{id}', 'UserController@destroy')->name('destroy')->middleware('auth', 'role:1');
});

Route::group(['prefix' => 'penyakit', 'as' => 'penyakit.'], static function () {
  Route::get('/', 'PenyakitController@index')->name('index')->middleware('auth', 'role:1');
  Route::post('/store', 'PenyakitController@store')->name('store')->middleware('auth', 'role:1');
  Route::post('/update/{id}', 'PenyakitController@update')->name('update')->middleware('auth', 'role:1');
  Route::get('/destroy/{id}', 'PenyakitController@destroy')->name('destroy')->middleware('auth', 'role:1');
});

Route::group(['prefix' => 'department', 'as' => 'department.'], static function () {
  Route::get('/', 'DepartementController@index')->name('index')->middleware('auth', 'role:1');
  Route::post('/store', 'DepartementController@store')->name('store')->middleware('auth', 'role:1');
  Route::post('/update/{id}', 'DepartementController@update')->name('update')->middleware('auth', 'role:1');
  Route::get('/destroy/{id}', 'DepartementController@destroy')->name('destroy')->middleware('auth', 'role:1');
});

Route::group(['prefix' => 'report', 'as' => 'report.'], static function () {
  Route::get('/', 'ReportController@index')->name('index')->middleware('auth', 'role:1|2');
  Route::get('/export', 'ReportController@export')->name('export')->middleware('auth', 'role:1');
  Route::get('/exportkadiv', 'ReportController@exportkadiv')->name('exportkadiv')->middleware('auth', 'role:2');
  Route::post('/sdm', 'ReportController@findSDM')->name('findSDM')->middleware('auth', 'role:1|2');
  Route::post('/devise', 'ReportController@findDevise')->name('findDevise')->middleware('auth', 'role:1|2');
  Route::post('/store', 'ReportController@store')->name('store')->middleware('auth', 'role:2|3');
  Route::get('/show/{id}', 'ReportController@show')->name('show')->middleware('auth');
  Route::get('/edit/{id}', 'ReportController@edit')->name('edit')->middleware('auth', 'role:1');
  Route::post('/update/{id}', 'ReportController@update')->name('update')->middleware('auth', 'role:1');
  Route::get('/destroy/{id}', 'ReportController@destroy')->name('destroy')->middleware('auth', 'role:1');
});