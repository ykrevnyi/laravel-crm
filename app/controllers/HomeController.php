<?php

class HomeController extends BaseController {

	/**
	 * Perform before actions
	 *
	 * @return void
	 */
	protected function before() {}


	/**
	 * Create default view parts
	 *
	 * @return void
	 */
	protected function beforeRender()
	{
		parent::beforeRender();
	}


	/**
	 * Show form for logining in
	 *
	 * @return void
	 */
	public function login()
	{
		$this->layout->content = View::make('common.login')
			->with('title', 'Авторизация');
	}


	/**
	 * Check form and try to login user
	 *
	 * @return void
	 */
	public function attempt()
	{
		$credentials = array(
			'email' => Input::get('email'),
			'password' => Input::get('password')
		);

		// Validate user input
		$v = Validator::make($credentials, array(
			'email' => 'required|email',
			'password' => 'required',
		), array(
			'required' => 'Поле :attribute обязательное для заполнения',
			'email' => 'Эл. почта введена неверно',
		));

		if ($v->passes())
		{
			$redmineUser = new RedmineUser();

			if ($redmineUser->auth($credentials))
			{
				return Redirect::route('admin');
			}
			else
			{
				return Redirect::back()
					->with(
						'redmine_user_error', 
						'Эл. почта или пароль неправильные!'
					);
			}
		}

		// If not, to login again
		return Redirect::back()->withErrors($v);
	}


	/**
	 * Simply logout user
	 *
	 * @return void
	 */
	public function logout()
	{
		Auth::logout();

		Redirect::route('login');
	}

}