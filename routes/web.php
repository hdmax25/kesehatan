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

Route::group(['prefix' => 'home', 'as' => 'home.'], static function () {
  Route::get('/belum', 'HomeController@belum')->name('belum')->middleware  ('auth');
  Route::get('/sehat', 'HomeController@sehat')->name('sehat')->middleware  ('auth');
  Route::get('/sakit', 'HomeController@belum')->name('sakit')->middleware  ('auth');
});

Route::group(['prefix' => 'user', 'as' => 'user.'], static function () {
  Route::get('/', 'UserController@index')->name('index')->middleware('auth', 'role:1');
  Route::get('/create', 'UserController@create')->name('create')->middleware('auth', 'role:1');
  Route::post('/store', 'UserController@store')->name('store')->middleware('auth', 'role:1');
  Route::get('/show/{id}', 'UserController@show')->name('show')->middleware('auth');
  Route::get('/edit/{id}', 'UserController@edit')->name('edit')->middleware('auth', 'role:1');
  Route::post('/update/{id}', 'UserController@update')->name('update')->middleware('auth', 'role:1');
  Route::post('/profile/update/{id}', 'UserController@updateProfile')->name('updateProfile')->middleware('auth');
  Route::post('/image/update/{id}', 'UserController@updateImage')->name('updateImage')->middleware('auth');
  Route::get('/destroy/{id}', 'UserController@destroy')->name('destroy')->middleware('auth', 'role:1');
});

Route::group(['prefix' => 'absent', 'as' => 'absent.'], static function () {
  Route::get('/', 'AbsentController@index')->name('index')->middleware('auth');
  Route::get('/show/{id}', 'AbsentController@show')->name('show')->middleware('auth');
  Route::post('/store', 'AbsentController@store')->name('store')->middleware('auth');
  Route::post('/update', 'AbsentController@update')->name('update')->middleware('auth');
  Route::get('/destroy/{id}', 'AbsentController@destroy')->name('destroy')->middleware('auth');
});

Route::group(['prefix' => 'TblAttendanceLog', 'as' => 'TblAttendanceLog.'], static function () {
  Route::get('/', 'TblAttendanceLogController@index')->name('index')->middleware('auth');
  Route::get('/show/{id}', 'TblAttendanceLogController@show')->name('show')->middleware('auth');
  Route::post('/store', 'TblAttendanceLogController@store')->name('store')->middleware('auth');
  Route::post('/update', 'TblAttendanceLogController@update')->name('update')->middleware('auth');
  Route::get('/destroy/{id}', 'TblAttendanceLogController@destroy')->name('destroy')->middleware('auth');
});

Route::group(['prefix' => 'leave', 'as' => 'leave.'], static function () {
  Route::get('/', 'LeaveController@index')->name('index')->middleware('auth');
  Route::get('/canceled', 'LeaveController@canceled')->name('canceled')->middleware('auth');
  Route::get('/expired', 'LeaveController@expired')->name('expired')->middleware('auth');
  Route::get('/create', 'LeaveController@create')->name('create')->middleware('auth');
  Route::get('/show/{id}', 'LeaveController@show')->name('show')->middleware('auth');
  Route::post('/store', 'LeaveController@store')->name('store')->middleware('auth');
  Route::post('/update/{id}', 'LeaveController@update')->name('update')->middleware('auth');
  Route::get('/destroy/{id}', 'LeaveController@destroy')->name('destroy')->middleware('auth');
  Route::get('/edit/{id}', 'LeaveController@edit')->name('edit')->middleware('auth');
  Route::get('/approve/{id}', 'LeaveController@approve')->name('approve')->middleware('auth');
  Route::get('/cancel/{id}', 'LeaveController@cancel')->name('cancel')->middleware('auth');
});

Route::group(['prefix' => 'site', 'as' => 'site.'], static function () {
  Route::get('/', 'SiteController@index')->name('index')->middleware('auth', 'role:1');
  Route::get('/show/{id}', 'SiteController@show')->name('show')->middleware('auth', 'role:1');
  Route::post('/store', 'SiteController@store')->name('store')->middleware('auth', 'role:1');
  Route::post('/update/{id}', 'SiteController@update')->name('update')->middleware('auth', 'role:1');
  Route::get('/destroy/{id}', 'SiteController@destroy')->name('destroy')->middleware('auth', 'role:1');
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
  Route::get('/export', 'ReportController@export')->name('export')->middleware('auth', 'role:1|2');
  Route::get('/daily', 'ReportController@daily')->name('daily')->middleware('auth', 'role:1');
  Route::get('/exportkadiv', 'ReportController@exportkadiv')->name('exportkadiv')->middleware('auth', 'role:2');
  Route::post('/sdm', 'ReportController@findSDM')->name('findSDM')->middleware('auth', 'role:1|2');
  Route::post('/devise', 'ReportController@findDevise')->name('findDevise')->middleware('auth', 'role:1|2');
  Route::post('/store', 'ReportController@store')->name('store')->middleware('auth', 'role:2|3');
  Route::get('/show/{id}', 'ReportController@show')->name('show')->middleware('auth');
  Route::get('/edit/{id}', 'ReportController@edit')->name('edit')->middleware('auth', 'role:1');
  Route::post('/update/{id}', 'ReportController@update')->name('update')->middleware('auth', 'role:1');
  Route::get('/destroy/{id}', 'ReportController@destroy')->name('destroy')->middleware('auth', 'role:1');
});