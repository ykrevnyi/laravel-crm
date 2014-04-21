<?php

class ProjectsController extends BaseController {

	protected $project, $redmineUser;

	public function before()
	{
		$this->redmineUser = new RedmineUser;
		$this->project = new Project($this->redmineUser);
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

		parse_str(Input::get('data'), $data);

		$project_id = $this->project->createProject($data);

		// Fetch all the users
		$all_users = $this->redmineUser->getAllWithPaginations(9999);
		$all_users_selectable = User::convertToSelectable($all_users['users']);

		// Get user roles
		$user_roles = UserRole::allForSelect();
		
		$view = View::make('projects.form_to_add_users')
			->with('project_id', $project_id)
			->with('users', $all_users_selectable)
			->with('user_roles', $user_roles);

		$result['view'] = htmlentities($view);
		$result['link_to_project'] = URL::route('projects.show', $project_id);

		return json_encode($result);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($project_id)
	{
		// Basic project info
		$project = $this->project->getProjectInfo($project_id);

		// Get related users
		$related_users = $this->project->getRelatedUsers($project_id);
		
		// Get related transactions
		$related_transactions = $this->project->getRelatedTransacitons($project_id);

		// Get user roles
		$user_roles = UserRole::allForSelect();

		// Get project billed hours
		$hours = $this->project->getBilledHours($project_id);

		// Get the rest balance of the payments
		$total_project_price = $this->project->calculateTotalPrice($hours);
		$total_transaction_price = $this->project->calculateTotalTransactionPrice($related_transactions);
		$project_balance	 = $total_project_price - $total_transaction_price;

		$this->layout->content = View::make('projects.show')
			->with('project', $project)
			->with('related_users', $related_users)
			->with('transactions', $related_transactions)
			->with('user_roles', $user_roles)
			->with('hours', $hours)
			->with('total_project_price', $total_project_price)
			->with('total_transaction_price', $total_transaction_price)
			->with('project_balance', $project_balance);
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

		// Get related users
		$related_users = $this->project->getRelatedUsers($project_id);

		// Fetch all the users
		$all_users = $this->redmineUser->getAllWithPaginations(9999);
		$all_users_selectable = User::convertToSelectable($all_users['users']);

		$related_users = $this->getRelatedUsers($all_users['users'], $related_users);
		
		// Get related transactions
		$related_transactions = $this->project->getRelatedTransacitons($project_id);

		// Get user roles
		$user_roles = UserRole::allForSelect();

		$this->layout->content = View::make('projects.edit')
			->with('project', $project)
			->with('users', $all_users_selectable)
			->with('related_users', $related_users)
			->with('priorities', $priorities)
			->with('transactions', $related_transactions)
			->with('user_roles', $user_roles);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($project_id)
	{
		// print_r(Input::all()); die();
		$this->project->saveProject(Input::all(), $project_id);
		
		return Redirect::back();
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


	/**
	 * Add user to the project
	 *
	 * @return mixed
	 */
	public function addUser($project_id)
	{
		$result = array();

		$project_id = (int) $project_id;
		$user_id = (int) Input::get('user_id', 0);
		$user_role_id = (int) Input::get('user_role_id', 0);
		$user_payed_hours = (int) Input::get('user_payed_hours', 0);

		$result['status'] = $this->project->addUserToProject($project_id, $user_id, $user_role_id, $user_payed_hours);

		// Get user info and create an HTML form to edit user relation to project
		$user = RedmineUser::GetById($user_id);
		$user->user_role_id = $user_role_id;
		$user->payed_hours = $user_payed_hours;

		// Get user roles
		$user_roles = UserRole::allForSelect();

		$view = View::make('projects.user_to_project_form')
			->with('user', $user)
			->with('user_roles', $user_roles);

		// Set output
		$result['user'] = $user;
		$result['view'] = htmlentities($view);

		return $result;
	}


	/**
	 * Remove user from the project
	 *
	 * @return mixed
	 */
	public function removeUser($project_id)
	{
		$result = array();

		$project_id = (int) $project_id;
		$user_id = (int) Input::get('user_id', 0);
		$user_role_id = (int) Input::get('user_role_id', 0);

		$result['status'] = $this->project->removeUserFromProject($project_id, $user_id, $user_role_id);

		return json_encode($result);
	}


	/**
	 * Change user role of the project
	 *
	 * @return void
	 */
	public function changeUserRole($project_id)
	{
		$result = array();

		$project_id = (int) $project_id;
		$user_id = (int) Input::get('user_id', 0);
		$user_role_id = (int) Input::get('user_role_id', 0);
		$prev_user_role_id = (int) Input::get('prev_user_role_id', 0);
		$user_payed_hours = (int) Input::get('user_payed_hours', 0);

		$result['status'] = $this->project->changeUserProjectRole(
			$project_id, 
			$user_id, 
			$user_role_id, 
			$prev_user_role_id,
			$user_payed_hours
		);

		return json_encode($result);
	}


	/**
	 * Change user payed hours
	 *
	 * @return void
	 */
	public function changeUserPayedHours($project_id)
	{
		$result = array();

		$project_id = (int) $project_id;
		$user_id = (int) Input::get('user_id', 0);
		$user_role_id = (int) Input::get('user_role_id', 0);
		$user_payed_hours = (int) Input::get('user_payed_hours', 0);

		$result['status'] = $this->project->changeUserProjectPayedHours(
			$project_id, 
			$user_id, 
			$user_role_id, 
			$user_payed_hours
		);

		return json_encode($result);
	}

}