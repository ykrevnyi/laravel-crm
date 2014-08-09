<?php

class BaseController extends Controller {

	protected $layout = 'default';
	protected $page;
	protected $redmineUser;


	public function __construct()
	{
		$this->redmineUser = new RedmineUser();
		$this->redmineUser->getUserInfo();

		$this->before();
	}


	/**
	 * Run before actions
	 *
	 * @return value
	 */
	protected function before()
	{
		throw new \RuntimeException("Controller does not implement before method.");
	}


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}

		// Run before actions
		$this->beforeRender();
	}


	/**
	 * Perform before render action for every controller
	 *
	 * @return void
	 */
	protected function beforeRender()
	{
		$this->page['routes'] = $this->getRoutes();

		// Get page info
		$this->page['title'] = 'Homepage title';

		// Bind header and footer
		$this->layout->header = View::make('common.header', $this->page);
		$this->layout->footer = View::make('common.footer', $this->page);
	}


	/**
	 * Get routes names
	 *
	 * @return mixed
	 */
	private function getRoutes()
	{
		$routes = array(
			'is_config' => false,
			'is_accounts' => false,
			'is_priorities' => false,
			'is_transaction_purposes' => false,
			'is_user_roles' => false,
			'is_home' => false,
			'is_users' => false,
			'is_transactions' => false,
			'is_projects' => false,
			'is_reports' => false,
			'is_currencies' => false
		);

		if (preg_match("/^accounts\.[^.]+$/i", Route::currentRouteName()))
		{
			$routes['is_config'] = true;
			$routes['is_accounts'] = true;
		}

		if (preg_match("/^currencies\.[^.]+$/i", Route::currentRouteName()))
		{
			$routes['is_config'] = true;
			$routes['is_currencies'] = true;
		}

		if (preg_match("/^priorities\.[^.]+$/i", Route::currentRouteName()))
		{
			$routes['is_config'] = true;
			$routes['is_priorities'] = true;
		}

		if (preg_match("/^transactions\.purposes\.[^.]+$/i", Route::currentRouteName()))
		{
			$routes['is_config'] = true;
			$routes['is_transaction_purposes'] = true;
		}

		if (preg_match("/^users\.roles\.[^.]+$/i", Route::currentRouteName()))
		{
			$routes['is_config'] = true;
			$routes['is_user_roles'] = true;
		}

		if (preg_match("/^home.*/i", Route::currentRouteName()))
		{
			$routes['is_home'] = true;
		}

		if (preg_match("/^users\.[^.]+$/i", Route::currentRouteName()))
		{
			$routes['is_users'] = true;
		}

		if (preg_match("/^transactions\.[^.]+$/i", Route::currentRouteName()))
		{
			$routes['is_transactions'] = true;
		}

		if (preg_match("/^projects\.[^.]+$/i", Route::currentRouteName()))
		{
			$routes['is_projects'] = true;
		}

		if (preg_match("/^reports\.[^.]+$/i", Route::currentRouteName()))
		{
			$routes['is_reports'] = true;
		}


		return $routes;
	}


}