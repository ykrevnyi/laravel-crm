<?php

class UsersController extends BaseController {

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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$task = new Task;

		// Get projects from specified dates.
		// Or from last month (by default)
		$date_from = Input::get('date_from', date('01-m-Y', strtotime('this month')));
		$date_to = Input::get('date_to', date('t-m-Y', strtotime('this month')));

		$date_from_formated = new DateTime($date_from);
		$date_to_formated = new DateTime($date_to);

		$user = new User;

		// Get all the projects related to the user
		$projects = $user->getUserProjects($id, $date_from_formated, $date_to_formated);

		// Get all the tasks (related roles) related to the user
		$tasks = $user->getTasks($id, 
			function($query) use ($date_from_formated, $date_to_formated) {
				return $query
					->whereBetween(
						'T.created_at', 
						array(
							$date_from_formated->format('Y-m-d'),
							$date_to_formated->format('Y-m-d')
						)
					);
			}
		);

		// Get user persents price (related to task)
		$user_persents_price = $user->getTotalUserMoneyOfPersents($id, 
			function($query) use ($date_from_formated, $date_to_formated) {
				return $query
					->whereBetween(
						'T.created_at', 
						array(
							$date_from_formated->format('Y-m-d'),
							$date_to_formated->format('Y-m-d')
						)
					)
					->whereRaw('T.created_at >= URP.created_at')
					->whereRaw('T.created_at < URP.deprecated_at');
			}
		);

		// Get user info
		$user_info = RedmineUser::getById($id);

		// Get all the transactions
		$transaction = new Transaction;
		$transactions = $transaction->getAll(
			function($query) use ($id, $date_from_formated, $date_to_formated) {
				return $query
					->where('transaction.transaction_object_type', 'user')
					->where('transaction.transaction_object_id', $id)
					->whereBetween(
						'transaction.created_at', 
						array(
							$date_from_formated->format('Y-m-d'),
							$date_to_formated->format('Y-m-d')
						)
					);
			}
		)->get();

		// Get totals
		// Get total price of all of the tasks
		$total_price = $task->calculateTotal($tasks);
		$total_price_percents = $user->calculateUserPercentsPrice($projects);
		$total_price_common = $total_price + $total_price_percents;
		$total_transaction_price = abs($transaction->calculateTotal($transactions));
		$user_balance = $total_price_common - $total_transaction_price;

		// Security
		$can_view = false;
		
		if (
			$this->redmineUser->getLocalUserID(RedmineUser::user()->mail)->id == $id OR 
			RedmineUser::user()->level == 'admin'
			)
		{
			$can_view = true;
		}

		$this->layout->content = View::make('users.show')
			->with('can_view', $can_view)

			->with('date_from', $date_from)
			->with('date_to', $date_to)
			->with('date_from_formated', $date_from_formated)
			->with('date_to_formated', $date_to_formated)
			
			->with('total_price', $total_price)
			->with('total_price_common', $total_price_common)
			->with('total_transaction_price', $total_transaction_price)
			->with('user_balance', $user_balance)
			->with('user_persents_price', $user_persents_price)

			->with('user', $user_info)
			->with('tasks', $tasks)
			->with('projects', $projects)
			->with('transactions', $transactions);
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}
	

}