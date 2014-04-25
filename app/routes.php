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
	// Route::post("/projects/{id}/addUser", array('as' => 'addUserToProject', 'uses' => 'ProjectsController@addUser'));
	// Route::post("/projects/{id}/removeUser", array('as' => 'removeUserFromProject', 'uses' => 'ProjectsController@removeUser'));
	// Route::post("/projects/{id}/changeUserRole", array('as' => 'changeUserProjectRole', 'uses' => 'ProjectsController@changeUserRole'));
	// Route::post("/projects/{id}/changeUserPayedHours", array('as' => 'changeUserProjectPayedHours', 'uses' => 'ProjectsController@changeUserPayedHours'));
	
	// Route::resource('tasks', 'TasksController');
	Route::delete("/projects/{project_id}/tasks/{task_id}", array('as' => 'task.destroy', 'uses' => 'TasksController@destroy'));
	Route::get("/projects/{id}/tasks/create", array('as' => 'task.create', 'uses' => 'TasksController@create'));
	Route::post("/projects/{id}/TasksController", array('as' => 'task.store', 'uses' => 'TasksController@store'));

	Route::post("/tasks/{id}/addUser", array('as' => 'addUserToTask', 'uses' => 'TasksController@addUser'));
	Route::post("/tasks/{id}/removeUser", array('as' => 'removeUserFromTask', 'uses' => 'TasksController@removeUser'));
	Route::post("/tasks/{id}/changeUserRole", array('as' => 'changeUserTaskRole', 'uses' => 'TasksController@changeUserRole'));
	Route::post("/tasks/{id}/changeUserPayedHours", array('as' => 'changeUserTaskPayedHours', 'uses' => 'TasksController@changeUserPayedHours'));
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