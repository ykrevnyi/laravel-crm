<?php 

class Task extends Eloquent
{
	
	protected $table = 'task';


	/**
	 * Get the total price of all of the tasks
	 *
	 * @return int
	 */
	public function calculateTotal($task_list)
	{
		$total = 0;

		foreach ($task_list as $task)
		{
			$total += $task->total_task_price;
		}

		return $total;
	}


	/**
	 * Get information of the task by id
	 *
	 * @return mixed
	 */
	public function getInfo($task_id)
	{
		// Get all of the tasks related to the project
		$task = DB::table('task')
			->where('id', $task_id)
			->first();

		$related_user_roles = $this->getTaskInvoice($task->id);
		$task->total_task_price = $this->calculateTaskUserRoles($related_user_roles);
		$task->related_user_roles = $related_user_roles;

		// Get users information (in our case only fname, lname)
		foreach ($task->related_user_roles as & $user)
		{
			$local_user = User::find($user->user_id);
			$redmine_user = RedmineUser::getRedmineUser($local_user->email);

			$user->firstname = $redmine_user->firstname;
			$user->lastname = $redmine_user->lastname;
		}
		
		return $task;
	}


	/**
	 * Simply store new task
	 *
	 * @return int
	 */
	public function scopeCreateTask($query, $project_id, $data)
	{
		return DB::table('task')->insertGetId(array(
			'project_id' => (int) $project_id,
			'name' => $data['name'],
			'short_description' => $data['short_description'],
			'description' => $data['description'],
			'created_at' => \Carbon\Carbon::now(),
			'updated_at' => \Carbon\Carbon::now()
		));
	}


	/**
	 * Simply update task
	 *
	 * @return int
	 */
	public function scopeUpdateTask($query, $task_id, $data)
	{
		return DB::table('task')
			->where('id', $task_id)
			->update(array(
				'name' => $data['name'],
				'short_description' => $data['short_description'],
				'description' => $data['description'],
				'updated_at' => \Carbon\Carbon::now()
			));
	}


	/**
	 * Add user to the task
	 *
	 * @return void
	 */
	public function scopeAddUserToTask($query, $task_id, $user_id, $user_role_id, $user_payed_hours)
	{
		if ($this->findUserWithParams($task_id, $user_id, $user_role_id) 
			OR ! $task_id OR ! $user_id OR ! $user_role_id)
		{
			return false;
		}

		DB::table('user_to_task')->insert(array(
			'task_id' => $task_id,
			'user_id' => $user_id,
			'payed_hours' => $user_payed_hours,
			'user_role_id' => $user_role_id
		));

		return true;
	}


	/**
	 * Remove user from the task
	 *
	 * @return void
	 */
	public function scopeRemoveUserFromTask($query, $task_id, $user_id, $user_role_id)
	{
		if ( ! $task_id OR ! $user_id OR ! $user_role_id)
		{
			return false;
		}

		DB::table('user_to_task')
			->where('task_id', '=', $task_id)
			->where('user_id', '=', $user_id)
			->where('user_role_id', '=', $user_role_id)
			->delete();

		return true;
	}


	/**
	 * Change user to task role
	 *
	 * @return void
	 */
	public function scopeChangeUserTaskRole($query, $task_id, $user_id, $user_role_id, $prev_user_role_id)
	{
		if ($this->findUserWithParams($task_id, $user_id, $user_role_id) 
			OR ! $task_id OR ! $user_id OR ! $user_role_id OR ! $prev_user_role_id)
		{
			return false;
		}

		DB::table('user_to_task')
			->where('task_id', '=', $task_id)
			->where('user_id', '=', $user_id)
			->where('user_role_id', '=', $prev_user_role_id)
			->update(array(
				'user_role_id' => $user_role_id
			));

		return true;
	}


	/**
	 * Change user payed hours
	 *
	 * @return void
	 */
	public function scopeChangeUserTaskPayedHours($query, $task_id, $user_id, $user_role_id, $user_payed_hours)
	{
		if ($user_payed_hours < 0)
		{
			$user_payed_hours = 0;
		}

		DB::table('user_to_task')
			->where('task_id', '=', $task_id)
			->where('user_id', '=', $user_id)
			->where('user_role_id', '=', $user_role_id)
			->update(array(
				'payed_hours' => $user_payed_hours
			));

		return true;
	}


	/**
	 * Here we are going to check if user (in task) with passed data already exists
	 *
	 * @return bool
	 */
	private function findUserWithParams($task_id, $user_id, $user_role_id)
	{
		$result = DB::table('user_to_task')
			->where('task_id', '=', $task_id)
			->where('user_id', '=', $user_id)
			->where('user_role_id', '=', $user_role_id)
			->first();

		return !! $result;
	}


	/**
	 * Get list of the tasks related to the project
	 *
	 * @return mixed
	 */
	public function getList($project_id)
	{
		// Get all of the tasks related to the project
		$task_list = DB::table('task')
			->where('project_id', '=', $project_id)
			->orderBy('task.created_at', 'desc')
			->get();

		foreach ($task_list as & $task)
		{
			$related_users = $this->getTaskInvoice($task->id);
			$task->total_task_price = $this->calculateTaskUserRoles($related_users);
			$task->related_users = $related_users;

			// Get users information (in our case only fname, lname)
			foreach ($task->related_users as & $user)
			{
				$local_user = User::find($user->user_id);
				$redmine_user = RedmineUser::getRedmineUser($local_user->email);

				$user->firstname = $redmine_user->firstname;
				$user->lastname = $redmine_user->lastname;
			}
		}
		
		return $task_list;
	}


	/**
	 * Get descriptive hours of the task
	 *
	 * @return mixed
	 */
	private function getTaskInvoice($task_id)
	{
		return DB::table('user_to_task as UTT')
			// Join project info in case to get project creating date
			->join(
				'task as T',
				'T.id',
				'=',
				'UTT.task_id'
			)

			// Join user role info
			->join(
				'user_role as UR',
				'UR.id',
				'=',
				'UTT.user_role_id'
			)

			// Join user role prices
			->join(
				'user_role_price as URP',
				'URP.user_role_id',
				'=',
				'UR.id'
			)

			// Get selected info
			->select(
				'UR.name as role_name',
				'URP.user_role_id',
				'URP.price_per_hour',
				'URP.created_at as user_role_price_created_at',
				'URP.deprecated_at as user_role_price_deprecated_at',
				'T.created_at as task_created_at',
				'UTT.user_id',
				'UTT.payed_hours',
				DB::raw('(UTT.payed_hours * URP.price_per_hour) as total_price')
			)
			->where('UTT.task_id', '=', $task_id)

			// Filter by dates (get price depending on creating date)
			->whereRaw('T.created_at >= URP.created_at')
			->whereRaw('T.created_at < URP.deprecated_at')

			->get();
	}


	/**
	 * Get users related to the task
	 *
	 * @return mixed
	 */
	public function getRelatedUsers($task_id)
	{
		$related_users = DB::table('task as T')
			// Join related users
			->join('user_to_task as UTT', 'UTT.task_id', '=', 'T.id')

			// Join user info
			->join('users as U', 'U.id', '=', 'UTT.user_id')

			// Join user role info
			->join(
				'user_role as UR',
				'UR.id',
				'=',
				'UTT.user_role_id'
			)

			->select(
				'UTT.user_id',
				'UTT.user_role_id',
				'UTT.payed_hours',
				'U.email AS user_email',
				'U.email AS user_email',
				'UR.name as role_name'
			)
			->where('T.id', '=', $task_id)

			->get();

		// Get users information
		$users = array();


		foreach ($related_users as & $user)
		{
			$redmineUser = RedmineUser::getRedmineUser($user->user_email);

			$user->firstname = $redmineUser->firstname;
			$user->lastname = $redmineUser->lastname;
		}
		
		return $related_users;
	}


	/**
	 * Get total price of all of the users related
	 *
	 * @return int
	 */
	private function calculateTaskUserRoles($task_related_users)
	{
		$total = 0;

		foreach ($task_related_users as $related_user)
		{
			$total += $related_user->total_price;
		}

		return $total;
	}

}