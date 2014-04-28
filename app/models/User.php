<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');


	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}


	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}


	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function getRememberToken() { return $this->remember_token; }
	public function setRememberToken($value) { $this->remember_token = $value; }
	public function getRememberTokenName() { return 'remember_token'; }


	/**
	 * Get full project list of current user with all needle data
	 *
	 * @return mixed
	 */
	public function getUserProjects($user_id, $filter = NULL)
	{
		$project_list_id_name = $this->getUserProjectsList($user_id, $filter);
		$project_list = $this->getProjectListDetails($project_list_id_name, $user_id);

		return $project_list;
	}


	/**
	 * Get all the tasks related to the user
	 *
	 * @return mixed
	 */
	public function getTasks($user_id, $filter = NULL)
	{
		$result = DB::table('task as T')
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

			// Join user role prices
			->join(
				'user_role_price as URP',
				'URP.user_role_id',
				'=',
				'UR.id'
			)

			->select(
				'T.name',
				'UTT.user_id',
				'UTT.user_role_id',
				'UTT.payed_hours',
				'U.email AS user_email',
				'U.email AS user_email',
				'UR.name as role_name',
				'URP.price_per_hour as period_price_per_hour',
				DB::raw('(UTT.payed_hours * URP.price_per_hour) as total_task_price'),
				'URP.created_at as period_created_at',
				'URP.deprecated_at as period_deprecated_at'
			)
			->where('UTT.user_id', '=', $user_id)

			->whereRaw('T.created_at >= URP.created_at')
			->whereRaw('T.created_at < URP.deprecated_at');

		if ($filter)
		{
			$result = $result->where($filter);
		}

		$result = $result->get();

		return $result;
	}


	/**
	 * Convert basic user list array to smth like
	 *
	 * -> $key => $value
	 * <- $user_id => $user_full_name
	 *
	 * @return void
	 */
	public function scopeConvertToSelectable($obj, $users)
	{
		$result = array();

		foreach ($users as $key => $user)
		{
			$result[$user->id] = $user->firstname . ' ' . $user->lastname;
		}

		return $result;
	}


	/**
	 * Get list of user projects
	 *
	 * <- [project_id, project_name]
	 *
	 * @return mixed
	 */
	private function getUserProjectsList($user_id, $filter = NULL)
	{
		$result = DB::table('user_to_task as UTT')
			// Get task info
			->join(
				'task as T',
				'T.id',
				'=',
				'UTT.task_id'
			)

			// Get project info
			->join(
				'project_description AS PD',
				'PD.project_id',
				'=',
				'T.project_id'
			)

			->select(
				'PD.project_id',
				'PD.name'
			)

			// Apply filters
			->where('UTT.user_id', $user_id);

		if ($filter)
		{
			$result = $result->where($filter);
		}

		// Group and order
		$result = $result
			->orderBy('T.project_id', 'desc')
			->groupBy('T.project_id')
			->get();

		return $result;
	}


	/**
	 * Complete user projects list with the prices and hours.
	 *
	 * Here we are going to get all needle hours and prices
	 * that are related to specific user
	 *
	 * <- [project_id, project_name, project_total_price, project_user_roles]
	 *
	 * @return mixed
	 */
	private function getProjectListDetails($project_list, $user_id)
	{
		$result = array();

		// Get detail project info
		foreach ($project_list as $project)
		{
			$related_user_roles = $this->getRelatedUsersTotal($project->project_id, $user_id);

			// Get total price
			$total_price = 0;
			foreach ($related_user_roles as $role)
			{
				$total_price += $role->period_total_price;
			}

			$result[] = array(
				'name' => $project->name,
				'total_price' => $total_price,
				'related_user_roles' => $related_user_roles
			);
		}
		
		return $result;
	}


	/**
	 * Get total user-to-project role payed hours
	 * 
	 * Example:
	 * 1st project - [dev: 10$, sdev: 20$]
	 * 2st project - [sdev: 30$]
	 *
	 * -> [dev: 10$, sdev: 50$]
	 *
	 * @return mixed
	 */
	private function getRelatedUsersTotal($project_id, $user_id)
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

			// Join user role prices
			->join(
				'user_role_price as URP',
				'URP.user_role_id',
				'=',
				'UR.id'
			)

			->select(
				'UTT.user_id',
				'UTT.user_role_id',
				'UTT.payed_hours',
				'U.email AS user_email',
				'U.email AS user_email',
				'UR.name as role_name',
				'URP.price_per_hour as period_price_per_hour',
				DB::raw('SUM(UTT.payed_hours * URP.price_per_hour) as period_total_price'),
				'URP.created_at as period_created_at',
				'URP.deprecated_at as period_deprecated_at'
			)
			->where('T.project_id', '=', $project_id)
			->where('UTT.user_id', '=', $user_id)

			->whereRaw('T.created_at >= URP.created_at')
			->whereRaw('T.created_at < URP.deprecated_at')

			->groupBy('UTT.user_role_id')

			->get();
		
		return $related_users;
	}
	

}