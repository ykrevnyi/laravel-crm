<?php namespace CRM\Api;


use CRM\Repositories\ApiUserRoleRepository;


class ApiUserRoleController extends \BaseController {

	private $date;
	private $repo;


	public function before() {
		// Create user role repo
		$this->repo = new ApiUserRoleRepository;

		// Get date if specified
		$date = \Input::get('date', date('d-m-Y', time()));
		$date = new \DateTime($date);

		$this->date = $date;
	}


	/**
	 * Create default view parts
	 *
	 * @return void
	 */
	protected function beforeRender() {}

	
	/**
	 * Display a listing of all the user roles by date in JSON
	 *
	 * @return Response
	 */
	public function json()
	{
		return $this->repo->getList($this->date->format('Y-m-d'));
	}


	/**
	 * Display a listing of all the user roles by date in JSON
	 *
	 * @return Response
	 */
	public function jsonp()
	{
		$roles = $this->repo->getList($this->date->format('Y-m-d'));
		$callback = \Input::get('callback', '[<b>YOU SHOULD SPECIFY CALLBACK]</b>');

		return $callback . '(' . json_encode($roles) . ')';
	}


}