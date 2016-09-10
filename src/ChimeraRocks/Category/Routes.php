<?php

Route::group([
	'prefix' => 'admin/categories', 
	'namespace' => 'ChimeraRocks\Category\Controllers',
	'as' => 'admin.categories.',
	'middleware' => ['web', 'auth', 'authorization:access_categories']
	], function() {
	Route::get('/', ['uses' => 'AdminCategoryController@index', 'as' => 'index']);
	Route::get('/create', ['uses' => 'AdminCategoryController@create', 'as' => 'create']);
	Route::post('/store', ['uses' => 'AdminCategoryController@store', 'as' => 'store']);
	Route::get('/edit/{id}', ['uses' => 'AdminCategoryController@edit', 'as' => 'edit']);
	Route::post('/update/{id}', ['uses' => 'AdminCategoryController@update', 'as' => 'update']);
	
});