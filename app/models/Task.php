<?php 

class Task extends Eloquent
{
	
	protected $table = 'task';



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

}