<?php

class AccountsController extends BaseController {


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

		$this->page['title'] = 'Список счетов';
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$accounts = MoneyAccount::all();

		$this->layout->content = View::make('accounts.index', compact('accounts'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->content = View::make('accounts.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$v = Validator::make(Input::all(), array(
			'name' => "required|unique:money_account|min:2|max:20"
		));

		if ($v->fails())
		{
			return Redirect::route('accounts.create')
				->withInput()
				->withErrors($v);
		}

		$account = new MoneyAccount;
		$account->name = Input::get('name');
		$account->save();

		return Redirect::route('accounts.index');
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
		$account = MoneyAccount::find($id);

		$this->layout->content = View::make('accounts.edit', compact('account'));
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
			'name' => "required|unique:money_account,name,$id|min:2|max:20"
		));

		if ($v->fails())
		{
			return Redirect::route('accounts.edit', $id)
				->withInput()
				->withErrors($v);
		}

		$account = MoneyAccount::find($id);
		$account->name = Input::get('name');
		$account->save();

		return Redirect::route('accounts.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		MoneyAccount::find($id)->delete();

		return Redirect::route('accounts.index');
	}

}