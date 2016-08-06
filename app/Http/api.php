<?php

//Route::group(['middleware' => 'web'], function(){
	Route::get('api/user', 'UserController@getUsers');
	Route::post('api/user', 'UserController@store');
//});