<?php

class TransactionController extends BaseController {


	protected function before() {}

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
		$transaction = new Transaction();
		$transactions = $transaction->getAll()->get();

		// Get money accounts
		$accounts = MoneyAccount::all();

		// Get all purposes
		$purposes = TransactionPurpose::all();

		// Fetch all the users
		$users = $this->redmineUser->getAllWithPaginations(99999);

		$this->layout->content = View::make(
			'transaction.index', 
			compact('transactions')
		)
		->with('money_accounts', $accounts)
		->with('purposes', $purposes)
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
		else
		{
			$input['object_id'] = 0;
		}

		// Validate user input
		$v = Validator::make($input, $rules);

		// If our basic validation passes
		if ($v->passes())
		{
			$transaction = new Transaction();
			$transaction->createTransaction($input);

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
		$transaction = new Transaction();

		// Removed without any problems
		if ($transaction->removeByID($id))
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

}