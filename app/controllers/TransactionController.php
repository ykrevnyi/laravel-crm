<?php

class TransactionController extends BaseController {


	private $projects, $transaction;


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

		$this->page['title'] = 'Список транзакций';
	}


	/**
	 * Check user permissions
	 *
	 * @return void
	 */
	function checkPermissions()
	{
		// Security
		if ( ! empty(RedmineUser::user()->level) AND RedmineUser::user()->level != 'admin')
		{
			return false;
		}

		return true;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Security
		if ( ! $this->checkPermissions())
		{
			Redirect::route('home')
				->with('error', 'У вас недостаточно прав для просмотра транзакций!');
		}

		$tools = new Tools;

		// Get projects from specified dates.
		// Or from last month (by default)
		$date_from = Input::get('date_from', date("d-m-Y", strtotime('-29 day')));
		$date_to = Input::get('date_to', date('d-m-Y', time()));
		$filter_name = Input::get('filter_name', '');

		$date_from_formated = new DateTime($date_from);
		$date_to_formated = new DateTime($date_to);

		$transactions = $this->transaction->getAll(
			function($query) use ($date_from_formated, $date_to_formated, $filter_name) {
				return $query
					->whereBetween(
						'transaction.created_at', 
						array(
							$date_from_formated->format('Y-m-d'),
							$date_to_formated->format('Y-m-d')
						)
					)
					->where('transaction_description.name', 'LIKE', '%' . $filter_name . '%');
			}
		)->get();

		// Convert dates like '2014-01-01' to 'today'
		$transactions = $tools->convertDates($transactions, 'trans_created_at', null, null);

		// Get money accounts
		$accounts = MoneyAccount::all();

		// Get all purposes
		$purposes = TransactionPurpose::all();

		// Fetch all the users
		$users = $this->redmineUser->getAllWithPaginations(99999);

		// Get all the projects
		$projects = $this->projects->getProjects();

		$this->layout->content = View::make('transaction.index')
			// Basic info
			->with('transactions', $transactions)
			->with('money_accounts', $accounts)
			->with('purposes', $purposes)
			->with('projects', $projects)

			// Dates
			->with('date_from', $date_from)
			->with('date_to', $date_to)
			->with('date_from_formated', $date_from_formated)
			->with('date_to_formated', $date_to_formated)

			// Users
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
		// Security
		if ( ! $this->checkPermissions())
		{
			echo "У вас не достаточно прав для данного действия!"; die();
		}

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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Security
		if ( ! $this->checkPermissions())
		{
			echo "У вас не достаточно прав для данного действия!"; die();
		}

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
	public function modal($relation_object_type = 'none', $relation_object_type_id = NULL)
	{
		// Security
		if ( ! $this->checkPermissions())
		{
			echo "У вас не достаточно прав для данного действия!"; die();
		}

		if (empty($relation_object_type))
		{
			$relation_object_type = 'none';
		}

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

		// Get current relation type
		if (Input::has('relation'))
		{
			$current_relation_object_type = Input::get('relation');
		}
		else
		{
			$current_relation_object_type = $relation_object_type;
		}

		// Get current relation type to project
		if (Input::old('relation_to_project') AND $current_relation_object_type == 'project')
		{
			$current_relation_object_type_id = Input::get('relation_to_project');
		}
		else
		{
			$current_relation_object_type_id = $relation_object_type_id;
		}

		// Get current relation type to user
		if (Input::old('relation_to_user') AND $current_relation_object_type == 'user')
		{
			$current_relation_object_type_id = Input::get('relation_to_user');
		}
		else
		{
			$current_relation_object_type_id = $relation_object_type_id;
		}


		return View::make('transaction.form')
			->with('relation_object_type', $relation_object_type)
			->with('current_relation_object_type', $current_relation_object_type)
			->with('current_relation_object_type_id', $current_relation_object_type_id)
			->with('relation_types', $relation_types)
			->with('money_accounts', $accounts)
			->with('purposes', $purposes)
			->with('projects', $projects)
			->with('users', $users);
	}


	/**
	 * Store newly created transaction
	 *
	 * @return void
	 */
	public function createTransaction()
	{
		// Security
		if ( ! $this->checkPermissions())
		{
			echo "У вас не достаточно прав для данного действия!"; die();
		}

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


}