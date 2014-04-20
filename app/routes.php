<?php

/*
 *------------------------------------------------------------
 *------------------------------------------------------------
 *	Only authed users can pass
 *------------------------------------------------------------
 *------------------------------------------------------------
 */
Route::group(array('before' => 'auth'), function () {
	Route::get('logout', array('as' => 'logout', 'uses' => 'HomeController@logout'));
	Route::get('/', array('as' => 'home', 'uses' => 'AdminController@index'));
	
	Route::resource('users', 'UsersController');
	
	Route::post("/transactions/modal", array('as' => 'transactionModalPost', 'uses' => 'TransactionController@createTransaction'));
	Route::get("/transactions/modal", array('as' => 'transactionModal', 'uses' => 'TransactionController@modal'));
	Route::resource('transactions', 'TransactionController');


	Route::resource('projects', 'ProjectsController');
	Route::post("/projects/{id}/addUser", array('as' => 'addUserToProject', 'uses' => 'ProjectsController@addUser'));
	Route::post("/projects/{id}/removeUser", array('as' => 'removeUserFromProject', 'uses' => 'ProjectsController@removeUser'));
	Route::post("/projects/{id}/changeUserRole", array('as' => 'changeUserProjectRole', 'uses' => 'ProjectsController@changeUserRole'));
	Route::post("/projects/{id}/changeUserPayedHours", array('as' => 'changeUserProjectPayedHours', 'uses' => 'ProjectsController@changeUserPayedHours'));
});


/*
 *------------------------------------------------------------
 *------------------------------------------------------------
 *	Only guests can pass
 *------------------------------------------------------------
 *------------------------------------------------------------
 */
Route::group(array('before' => 'guest'), function () {
	Route::get('login', array('as' => 'login', 'uses' => 'HomeController@login'));

	Route::post('login', array('as' => 'attempt', 'uses' => 'HomeController@attempt'));
});


/*
 *------------------------------------------------------------
 *------------------------------------------------------------
 *	Everyone can pass
 *------------------------------------------------------------
 *------------------------------------------------------------
 */
// Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));