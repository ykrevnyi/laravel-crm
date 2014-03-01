<?php

class BaseController extends Controller {

	protected $layout = 'default';
	protected $page;


	public function __construct()
	{
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
		// Get page info
		$this->page['title'] = 'Homepage title';

		// Bind header and footer
		$this->layout->header = View::make('common.header', $this->page);
		$this->layout->footer = View::make('common.footer', $this->page);
	}

}