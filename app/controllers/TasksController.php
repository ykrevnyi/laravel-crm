<?php

class TasksController extends \BaseController {

	protected $redmineUser;

	public function before()
	{
		$this->redmineUser = new RedmineUser;
	}


	protected function beforeRender()
	{
		parent::beforeRender();

		// Bind header and footer
		$this->layout->header = View::make('admin.common.header', $this->page);
		$this->layout->footer = View::make('admin.common.footer', $this->page);

		$this->page['title'] = 'Tasks';
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($project_id)
	{
		return View::make('tasks.create')
			->with('project_id', $project_id);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$result = array( 'status' => true );
		$rules = array(
			'name' => 'required',
			'short_description' => 'required',
			'description' => 'required'
		);

		// Parse serialized (jQuery) data
		parse_str(Input::get('data'), $input);

		$v = Validator::make($input, $rules);

		// Validate data
		if ($v->fails())
		{
			$result['status'] = false;
			$result['messages'] = json_decode($v->messages()->toJson());

			return json_encode($result, true);
		}

		// Create new task and get the id
		$task_id = Task::createTask(Input::get('project_id', 0), $input);

		// Fetch all the users
		$all_users = $this->redmineUser->getAllWithPaginations(9999);
		$all_users_selectable = User::convertToSelectable($all_users['users']);

		// Get user roles
		$user_roles = UserRole::allForSelect();

		// Show form for adding users to that task
		$view = View::make('tasks.add_users')
			->with('task_id', $task_id)
			->with('users', $all_users_selectable)
			->with('user_roles', $user_roles);

		$result['view'] = htmlentities($view);

		return json_encode($result, true);
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
	public function edit($project_id, $task_id)
	{
		// Get basic task info
		$task = new Task;
		$taskInfo = $task->getInfo($task_id);

		// Get related users
		$related_users = $task->getRelatedUsers($task_id);

		// Fetch all the users
		$all_users = $this->redmineUser->getAllWithPaginations(9999);
		$all_users_selectable = User::convertToSelectable($all_users['users']);

		// Get user roles
		$user_roles = UserRole::allForSelect();

		return View::make('tasks.edit')
			->with('project_id', $project_id)
			->with('users', $all_users_selectable)
			->with('related_users', $related_users)
			->with('user_roles', $user_roles)
			->with('task_id', $task_id)
			->with('task', $taskInfo);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($project_id, $task_id)
	{
		$result = array( 'status' => true );
		$rules = array(
			'name' => 'required',
			'short_description' => 'required',
			'description' => 'required'
		);

		// Parse serialized (jQuery) data
		parse_str(Input::get('data'), $input);

		$v = Validator::make($input, $rules);

		// Validate data
		if ($v->fails())
		{
			$result['status'] = false;
			$result['messages'] = json_decode($v->messages()->toJson());

			return json_encode($result, true);
		}

		// Create new task and get the id
		Task::updateTask($task_id, $input);

		return json_encode($result, true);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($project_id, $task_id)
	{
		$result = array( 'status' => true );

		$result['status'] = DB::table('task')
			->where('id', '=', $task_id)
			->delete();

		return json_encode($result);
	}


	/**
	 * Add user to the project
	 *
	 * @return mixed
	 */
	public function addUser($task_id)
	{
		$result = array();

		$task_id = (int) $task_id;
		$user_id = (int) Input::get('user_id', 0);
		$user_role_id = (int) Input::get('user_role_id', 0);
		$user_payed_hours = (int) Input::get('user_payed_hours', 0);

		$result['status'] = Task::addUserToTask($task_id, $user_id, $user_role_id, $user_payed_hours);

		// Get user info and create an HTML form to edit user relation to project
		$user = RedmineUser::GetById($user_id);
		$user->user_role_id = $user_role_id;
		$user->payed_hours = $user_payed_hours;

		// Get user roles
		$user_roles = UserRole::allForSelect();

		$view = View::make('tasks.user_to_project_form')
			->with('user', $user)
			->with('user_roles', $user_roles);

		// Set output
		$result['user'] = $user;
		$result['view'] = htmlentities($view);

		return json_encode($result);
	}


	/**
	 * Remove user from the project
	 *
	 * @return mixed
	 */
	public function removeUser($task_id)
	{
		$result = array();

		$task_id = (int) $task_id;
		$user_id = (int) Input::get('user_id', 0);
		$user_role_id = (int) Input::get('user_role_id', 0);

		$result['status'] = Task::removeUserFromTask($task_id, $user_id, $user_role_id);

		return json_encode($result);
	}


	/**
	 * Change user role of the project
	 *
	 * @return void
	 */
	public function changeUserRole($task_id)
	{
		$result = array();

		$task_id = (int) $task_id;
		$user_id = (int) Input::get('user_id', 0);
		$user_role_id = (int) Input::get('user_role_id', 0);
		$prev_user_role_id = (int) Input::get('prev_user_role_id', 0);
		$user_payed_hours = (int) Input::get('user_payed_hours', 0);

		$result['status'] = Task::changeUserTaskRole(
			$task_id, 
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
	public function changeUserPayedHours($task_id)
	{
		$result = array();

		$task_id = (int) $task_id;
		$user_id = (int) Input::get('user_id', 0);
		$user_role_id = (int) Input::get('user_role_id', 0);
		$user_payed_hours = (int) Input::get('user_payed_hours', 0);

		$result['status'] = Task::changeUserTaskPayedHours(
			$task_id, 
			$user_id, 
			$user_role_id, 
			$user_payed_hours
		);

		return json_encode($result);
	}

}