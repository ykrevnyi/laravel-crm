<?php

class UsersController extends BaseController {

	public function before()
	{
	}

	/**
	 * Create default view parts
	 *
	 * @return void
	 */
	protected function beforeRender()
	{
		parent::beforeRender();

		// Bind header and footer
		$this->layout->header = View::make('admin.common.header', $this->page);
		$this->layout->footer = View::make('admin.common.footer', $this->page);

		$this->page['title'] = 'User list page';
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = $this->redmineUser->getAllWithPaginations();

		$this->layout->content = View::make('users.index', compact('data'))
			->with('title', $this->page['title']);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Get projects from specified dates.
		// Or from last month (by default)
		$date_from = Input::get('date_from', date('01-m-Y', strtotime('this month')));
		$date_to = Input::get('date_to', date('t-m-Y', strtotime('this month')));

		$date_from_formated = new DateTime($date_from);
		$date_to_formated = new DateTime($date_to);

		$user = new User;
		$projects = $user->getUserProjects($id);

		// Get user info
		$user_info = RedmineUser::getById($id);

		$this->layout->content = View::make('users.show')
			->with('date_from', $date_from)
			->with('date_to', $date_to)
			->with('date_from_formated', $date_from_formated)
			->with('date_to_formated', $date_to_formated)
			
			->with('user', $user_info)
			->with('projects', $projects);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (RedmineUser::user()->level != 'admin')
		{
			return array(
				'error' => 'Недостаточно прав доступа!'
			);
		}

		$user = User::find($id);
		$user->perm = Input::get('perm');
		$user->save();

		return array(
			'success' => 'Права успешно изменены!'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
