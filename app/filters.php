<?php

/*
 *------------------------------------------------------------
 *------------------------------------------------------------
 *	BEFORE APPLICATION
 *------------------------------------------------------------
 *------------------------------------------------------------
 */
App::before(function ($resp) {
	// Disable cache
	// header("Content-Type: application/json");
	// header("Expires: 0");
	// header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	// header("Cache-Control: no-store, no-cache, must-revalidate");
	// header("Cache-Control: post-check=0, pre-check=0", false);
	// header("Pragma: no-cache");
});


/*
 *------------------------------------------------------------
 *------------------------------------------------------------
 *	AFTER APPLICATION
 *------------------------------------------------------------
 *------------------------------------------------------------
 */
App::after(function($request, $response)
{

});


/*
 *------------------------------------------------------------
 *------------------------------------------------------------
 *	FILTERS
 *------------------------------------------------------------
 *------------------------------------------------------------
 */
// Check if user logged
Route::filter('auth', function ($route) {
	if ( ! Auth::check()) return Redirect::route('login');
});

// Check if user NOT logged
Route::filter('guest', function ($route) {
	if (Auth::check()) return Redirect::route('home');
});


/*
 *------------------------------------------------------------
 *------------------------------------------------------------
 *	SYSTEM FILTERS
 *------------------------------------------------------------
 *------------------------------------------------------------
 */
Route::filter('auth.basic', function()
{
	return Auth::basic();
});


Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});