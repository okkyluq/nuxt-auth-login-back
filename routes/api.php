<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['api']], function(){
	Route::post('/signup', 'AuthController@signup');
	Route::post('/signin', 'AuthController@signin');
	Route::get('/data/user', 'AuthController@getdata');
	Route::group(['middleware' => ['jwt.auth']], function(){
		Route::get('/data', function(){
			$data = [['nama' => 'luqman', 'alamat' => 'Jln.Berua', 'nohp' => '081242055108'], ['nama' => 'luqman', 'alamat' => 'Jln.Berua', 'nohp' => '081242055108'], ];
			return response()->json($data);
		});
		Route::get('/user', 'AuthController@infoUser');
		// Route::get('/signout', 'AuthController@signout');
	});
});





