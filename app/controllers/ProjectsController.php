<?php

class ProjectsController extends BaseController {

	protected $project;


	public function before()
	{
		$this->project = new Project(new RedmineUser);
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

		$this->page['title'] = 'Список проектов';
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Get projects from specified dates.
		// Or from last month (by default)
		$date_from = Input::get('date_from', date("d-m-Y", strtotime('-29 day')));
		$date_to = Input::get('date_to', date('d-m-Y', time()));
		$filter_name = Input::get('filter_name', '');

		$date_from_formated = new DateTime($date_from);
		$date_to_formated = new DateTime($date_to);

		$project_list = $this->project->getProjects(
			$date_from_formated, 
			$date_to_formated, 
			$filter_name
		);

		// Here we are going to conver dates like '2014-01-01' to 'today'
		$tools = new Tools;
		$project_list = $tools->convertDates($project_list, 'proj_created_at', null, 'proj_end_date');

		$this->layout->content = View::make('projects.index')
			->with('project_list', $project_list)
			->with('date_from', $date_from)
			->with('date_to', $date_to)
			->with('date_from_formated', $date_from_formated)
			->with('date_to_formated', $date_to_formated);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Get all the project priorities
		$priorities = ProjectPriority::getAllConvertedToView();

		// Get user roles
		$user_roles = UserRole::allForSelect();

		$this->layout->content = View::make('projects.create')
			->with('priorities', $priorities)
			->with('user_roles', $user_roles);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$result = array();

		$v = Validator::make(Input::all(), array(
			'proj_name' => array("required", "min:2", "max:20"),
			'proj_desc_short' => array("required", "min:10"),
			'proj_end_date' => array("required"),
			'proj_persents' => array("regex:/^(100|0|[1-9]\d?)$/")
		));

		if ($v->fails())
		{
			return Redirect::route('projects.create')
				->withInput()
				->withErrors($v);
		}

		$project_id = $this->project->createProject(Input::all());
		
		$result['link_to_project'] = URL::route('projects.show', $project_id);

		return Redirect::route('projects.show', array('id' => $project_id));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($project_id)
	{
		$transaction = new Transaction;
		$tools = new Tools;
		$task = new Task;

		// Basic project info
		$project = $this->project->getProjectInfo($project_id);
		$project->proj_end_date_human = $tools->resolveDate($project->proj_end_date);
		$project->proj_created_at_human = $tools->resolveDate($project->proj_created_at);
		$project->proj_updated_at_human = $tools->resolveDate($project->proj_updated_at);

		// Get total related users (with total project price)
		$related_users = $this->project->getRelatedUsers($project_id);
		$related_users = $tools->checkUserRolePeriod($related_users, 'period_deprecated_at');
		$related_users_totals = $this->project->getRelatedUsersTotal($project_id);
		
		// Get related transactions AND convert dates like '2014-01-01' to 'today'
		$related_transactions = $this->project->getRelatedTransacitons($project_id);
		$related_transactions = $tools->convertDates($related_transactions, 'trans_created_at', null, null);

		// Get user roles
		$user_roles = UserRole::allForSelect();

		// Get related tasks AND convert dates like '2014-01-01' to 'today'
		$related_tasks = $task->getList($project_id);
		$related_tasks = $tools->convertDates($related_tasks, 'created_at', null, null);

		// Get the rest balance of the payments
		$total_project_price = $task->calculateTotal($related_tasks);
		$total_transaction_price = $transaction->calculateTotalConverted($related_transactions);
		$project_balance = $total_project_price - $total_transaction_price;

		$content = View::make('projects.show')
			->with('project', $project)
			->with('related_users', $related_users)
			->with('related_users_totals', $related_users_totals)
			->with('transactions', $related_transactions)
			->with('user_roles', $user_roles)
			->with('total_project_price', $total_project_price)
			->with('total_transaction_price', $total_transaction_price)
			->with('project_balance', $project_balance)
			->with('related_tasks', $related_tasks);

		// If request was via ajax
		// We will not be returning header + footer
		if (Request::ajax())
		{
			return $content;
		}
		else
		{
			$this->layout->content = $content;
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($project_id)
	{
		// Basic project info
		$project = $this->project->getProjectInfo($project_id);

		// Get all the project priorities
		$priorities = ProjectPriority::getAllConvertedToView();

		$this->layout->content = View::make('projects.edit')
			->with('project', $project)
			->with('priorities', $priorities);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($project_id)
	{
		$v = Validator::make(Input::all(), array(
			'proj_name' => array("required", "min:2", "max:20"),
			'proj_desc_short' => array("required", "min:10"),
			'proj_end_date' => array("required"),
			'proj_persents' => array("regex:/^(100|0|[1-9]\d?)$/")
		));

		if ($v->fails())
		{
			return Redirect::route('projects.edit', $project_id)
				->withInput()
				->withErrors($v);
		}

		$this->project->saveProject(Input::all(), $project_id);
		
		return Redirect::route('projects.show', $project_id);
	}
	

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($project_id)
	{
		$this->project->remove($project_id);

		return Redirect::route('projects.index');
	}


	/**
	 * Get selected users
	 *
	 * Here we have two arrays
	 * 1st one has all users information
	 * 2d has only selected `user_id`s
	 *
	 * Then we age going to simply merge this stuff
	 *
	 * @return mixed
	 */
	private function getRelatedUsers($all_users = array(), $related_users = array())
	{
		$selected_users = array();

		foreach ($all_users as $user)
		{
			foreach ($related_users as $related_user)
			{
				if ($user->id == $related_user->id)
				{
					$selected_users[] = array(
						'id' => $related_user->id,
						'firstname' => $related_user->firstname,
						'lastname' => $related_user->lastname,
						'fullname' => $related_user->firstname . ' ' .$related_user->lastname,
						'mail' => $related_user->mail,
						'login' => $related_user->login,
						'payed_hours' => $related_user->payed_hours,
						'user_role_id' => $related_user->user_role_id
					);
				}
			}
		}

		return $selected_users;
	}


}