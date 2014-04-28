<?php

class UsersRoleController extends BaseController {


	public function before() {}


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

		$this->page['title'] = 'Должности пользователей';
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$rolesModel = new UserRole;
		$roles = $rolesModel->getList();

		$this->layout->content = View::make('users.roles.index', compact('roles'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->content = View::make('users.roles.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$v = Validator::make(Input::all(), array(
			'name' => 'required|alpha_dash',
			'price_per_hour' => 'required|numeric',
			'price_per_hour_payable' => 'required|numeric'
		));

		if ($v->fails())
		{
			return Redirect::route('users.roles.create')
				->withInput()
				->withErrors($v);
		}

		$rolesModel = new UserRole;
		$rolesModel->createRole(Input::all());

		return Redirect::route('users.roles.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rolesModel = new UserRole;
		$role = $rolesModel->getRole($id);
		$prices_history = $rolesModel->getPriceHistory($id);

		$this->layout->content = View::make('users.roles.edit')
			->with('role', $role)
			->with('prices_history', $prices_history);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$v = Validator::make(Input::all(), array(
			'name' => 'required|alpha_dash',
			'price_per_hour' => 'required|numeric',
			'price_per_hour_payable' => 'required|numeric'
		));

		if ($v->fails())
		{
			return Redirect::route('users.roles.edit', $id)
				->withInput()
				->withErrors($v);
		}

		$rolesModel = new UserRole;
		$rolesModel->updateRole($id, Input::all());

		return Redirect::route('users.roles.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		TransactionPurpose::find($id)->delete();

		return Redirect::route('users.roles.index');
	}

}