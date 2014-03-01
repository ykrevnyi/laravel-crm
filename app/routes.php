<?php


// $password = 'qwerta123';
// $salt = '13c71df825089ef46d3e1e1beac824be';

// echo sha1($salt . sha1($password));
// die();

// // qwerta123
// // hmhtcu1W2p5x0bE3d8oyEerC6vx56v3abkFNKfaUTMVLWTRY4iKO2

// print_r(DB::connection('redmine')->table('users')->get());

// // redmine
// // fa576df629ceeb2cc42ae2b1f62ae3f0d3302eeb



// // die();

/*
 *------------------------------------------------------------
 *------------------------------------------------------------
 *	Only authed users can pass
 *------------------------------------------------------------
 *------------------------------------------------------------
 */
Route::group(array('before' => 'auth'), function () {
	Route::get('logout', array('as' => 'logout', 'uses' => 'HomeController@logout'));
	Route::get('admin', array('as' => 'admin', 'uses' => 'AdminController@index'));
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
Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::resource('users', 'UsersController');