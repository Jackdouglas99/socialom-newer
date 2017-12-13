<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api', 'as' => 'api.'], function(){
	Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
		Route::get('/notification/read', 'API\User\NotificationController@markAsRead')->name('notification.markasread');

		Route::group(['prefix' => 'friend-request', 'as' => 'friend-request.'], function(){
			Route::post('send', 'API\User\FriendRequestController@sendFriendRequest')->name('send');
			Route::post('update', 'API\User\FriendRequestController@updateFriendRequest')->name('update');
		});

		Route::group(['prefix' => 'report', 'as' => 'report.'], function(){
			Route::post('/new', 'API\User\ReportController@newReport')->name('new');
		});

		Route::group(['prefix' => 'settings', 'as' => 'settings.'], function(){
			Route::post('profile', 'API\User\SettingsController@saveProfile')->name('profile');
			Route::post('password', 'API\User\SettingsController@savePassword')->name('password');
			Route::post('privacy', 'API\User\SettingsController@savePrivacy')->name('privacy');
		});

		Route::group(['prefix' => 'post', 'as' => 'post.'], function(){
			Route::post('/new', 'API\User\PostController@newPost')->name('new');
			Route::post('/delete', 'API\User\PostController@deletePost')->name('delete');
			Route::post('/edit', 'API\User\PostController@editPost')->name('edit');
			Route::post('/like', 'API\User\PostController@likePost')->name('like');
		});
	});

	Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
		Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
			Route::post('/updateSuspended', 'API\Admin\UserController@updateSuspended')->name('updateSuspended');
			Route::post('/updateVerified', 'API\Admin\UserController@updateVerified')->name('updateVerified');
			Route::post('/updateRole', 'API\Admin\UserController@updateRole')->name('updateRole');
			Route::post('/updateInfo', 'API\Admin\UserController@updateInfo')->name('updateInfo');
		});

	});
});
