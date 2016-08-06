<?php

//Auth::loginUsingId(1);

Route::group(['middleware' => 'auth'], function(){
	Route::get('/', 'DashboardController@index');

	Route::get('auth/user', 'Auth\AuthController@index');
});

