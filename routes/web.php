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

	Route::group(['middleware' => 'admin','prefix' => 'admin', 'as' => 'admin.'], function(){
		Route::get('', 'Admin\DashboardController@index')->name('dashboard');
		Route::get('/users', 'Admin\UserController@users')->name('users');
		Route::get('/users/{user_id}/view', 'Admin\UserController@user')->name('user');
		Route::get('/posts', 'Admin\PostController@posts')->name('posts');
		Route::get('/posts/{post_id}/view', 'Admin\PostController@post')->name('post');
		Route::get('/posts/{post_id}/delete', 'Admin\PostController@deletePost')->name('post.delete');
	});
});