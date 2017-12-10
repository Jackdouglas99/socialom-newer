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

Auth::routes();

Route::get('/welcome', function(){ return view('welcome'); })->name('welcome');
Route::get('/terms', function(){ return view('terms'); })->name('terms');

Route::group(['middleware' => 'auth'], function(){
	Route::get('', 'User\HomeController@index')->name('index');
	Route::get('/settings', 'User\SettingsController@index')->name('settings');
	Route::get('/p/{user}', 'User\ProfileController@getProfile')->name('profile');
	Route::get('/test/{user_id}/{post_id}', 'API\User\NotificationController@test');
});