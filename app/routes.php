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
	
	// User roles management
	Route::resource('users/roles', 'UsersRoleController');

	// Users
	Route::resource('users', 'UsersController');
	
	// Transaction destination management
	Route::resource('transactions/purposes', 'TransactionPurposeController');

	// Transactions
	Route::post("/transactions/modal/{relation_object_type?}/{relation_object_type_id?}", array('as' => 'transactionModalPost', 'uses' => 'TransactionController@createTransaction'));
	Route::get("/transactions/modal/{relation_object_type?}/{relation_object_type_id?}", array('as' => 'transactionModal', 'uses' => 'TransactionController@modal'));
	Route::resource('transactions', 'TransactionController');

	// Projects
	Route::resource('projects', 'ProjectsController');
	
	Route::delete("/projects/{project_id}/tasks/{task_id}", array('as' => 'task.destroy', 'uses' => 'TasksController@destroy'));
	Route::get("/projects/{id}/tasks/create", array('as' => 'task.create', 'uses' => 'TasksController@create'));
	Route::get("/projects/{project_id}/tasks/{task_id}/edit", array('as' => 'task.edit', 'uses' => 'TasksController@edit'));
	Route::post("/projects/{id}", array('as' => 'task.store', 'uses' => 'TasksController@store'));
	Route::put("/projects/{project_id}/tasks/{task_id}", array('as' => 'task.update', 'uses' => 'TasksController@update'));

	// Tasks
	Route::post("/tasks/{id}/addUser", array('as' => 'addUserToTask', 'uses' => 'TasksController@addUser'));
	Route::post("/tasks/{id}/removeUser", array('as' => 'removeUserFromTask', 'uses' => 'TasksController@removeUser'));
	Route::post("/tasks/{id}/changeUserRole", array('as' => 'changeUserTaskRole', 'uses' => 'TasksController@changeUserRole'));
	Route::post("/tasks/{id}/changeUserPayedHours", array('as' => 'changeUserTaskPayedHours', 'uses' => 'TasksController@changeUserPayedHours'));

	// Accounts management
	Route::resource('accounts', 'AccountsController');

	// Priorities management
	Route::resource('priorities', 'PrioritiesController');

	// Priorities management
	Route::resource('priorities', 'PrioritiesController');
	
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