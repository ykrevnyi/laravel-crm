<?php

class TransactionController extends BaseController {

	private $projects;
	private $transaction;

	protected function before() {
		$this->projects = new Project(new RedmineUser);
		$this->transaction = new Transaction;
	}


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
		$transactions = $this->transaction->getAll()->get();

		// Get money accounts
		$accounts = MoneyAccount::all();

		// Get all purposes
		$purposes = TransactionPurpose::all();

		// Fetch all the users
		$users = $this->redmineUser->getAllWithPaginations(99999);

		// Get all the projects
		$projects = $this->projects->getProjects();

		$this->layout->content = View::make(
			'transaction.index', 
			compact('transactions')
		)
		->with('money_accounts', $accounts)
		->with('purposes', $purposes)
		->with('projects', $projects)
		->with('users', $users);
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
		$rules = array(
			'is_expense' => 'required',
			'name' => 'required',
			'transaction_purpose_id' => 'required',
			'price' => 'required',
			'money_account' => 'required',
			'relation' => 'required'
		);

		$input = Input::all();

		// Check relation data
		if (Input::get('relation') == 'user')
		{
			$input['object_id'] = Input::get('relation_to_user');
			$rules['object_id'] = 'required';
		}
		elseif (Input::get('relation') == 'project')
		{
			$input['object_id'] = Input::get('relation_to_project');
			$rules['object_id'] = 'required';
		}
		else
		{
			$input['object_id'] = 0;
		}

		// Validate user input
		$v = Validator::make($input, $rules);

		// If our basic validation passes
		if ($v->passes())
		{
			$this->transaction->createTransaction($input);

			return array(
				'success' => 'Транзакция добавленна!'
			);
		}
		else
		{
			return array(
				'error' => 'Заполните все поля!'
			);
		}
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Removed without any problems
		if ($this->transaction->removeByID($id))
		{
			return json_encode(array(
				'success' => 'Транзакция удалена!'
			));
		}

		// An error occupied
		else
		{
			return json_encode(array(
				'error' => 'Возникла ошибка во время удаления транзакции.'
			));
		}
	}


	/**
	 * Show modal form to create new transaction
	 *
	 * @return mixed
	 */
	public function modal()
	{
		// Get money accounts
		$accounts = MoneyAccount::all();

		// Get all purposes
		$purposes = TransactionPurpose::all();

		// Fetch all the users
		$users = $this->redmineUser->getAllWithPaginations(99999);
		$users = User::convertToSelectable($users['users']);

		// Get all the projects
		$projects = $this->projects->getProjects();
		$projects = Tools::convertProjectToSelectable($projects);

		// List of relation types
		$relation_types = array(
			'none' => 'без привязки',
			'user' => 'к пользователю',
			'project' => 'к проекту'
		);

		return View::make('transaction.form')
			->with('relation_types', $relation_types)
			->with('money_accounts', $accounts)
			->with('purposes', $purposes)
			->with('projects', $projects)
			->with('users', $users);
	}


	public function createTransaction()
	{
		$input = Input::all();

		$filter = array(
			'is_expense' => 'required',
			'name' => 'required|min:5',
			'transaction_purpose_id' => 'required',
			'money_account' => 'required',
			'price' => 'required|numeric',
			'relation' => 'required'
		);

		// No relation here
		if (Input::get('relation') == 'none')
		{
			$input['object_id'] = 0;
		}

		// Relation to user
		elseif (Input::get('relation') == 'user')
		{
			$input['object_id'] = Input::get('relation_to_user');
			$filter['relation_to_user'] = 'required';
		}

		// Relation to project
		elseif (Input::get('relation') == 'project')
		{
			$input['object_id'] = Input::get('relation_to_project');
			$filter['relation_to_user'] = 'required';
		}

		$validator = Validator::make(
			$input,
			$filter
		);

		if ($validator->fails())
		{
			return Redirect::route('transactionModal')
				->withInput()
				->withErrors($validator);
		}

		$this->transaction->createTransaction($input);
		Session::put('success', 'Транзакция добавлена!');

		return Redirect::route('transactionModal');
	}


}