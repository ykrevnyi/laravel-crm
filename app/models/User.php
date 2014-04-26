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
	 * @return mixed
	 */
	public function getUserProjects($user_id, $filter = NULL)
	{
		$projectModel = new Project(new RedmineUser);

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

		$user_related_projects = $result;
		$list = array();

		// Get detail project info
		foreach ($user_related_projects as $project)
		{
			$related_user_roles = $this->getRelatedUsersTotal($project->project_id, $user_id);

			// Get total price
			$total_price = 0;
			foreach ($related_user_roles as $role)
			{
				$total_price += $role->period_total_price;
			}

			$list[] = array(
				'name' => $project->name,
				'total_price' => $total_price,
				'related_user_roles' => $related_user_roles
			);
		}
		
		return $list;
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
	public function getRelatedUsersTotal($project_id, $user_id)
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


	/**
	 * Get user project details
	 *
	 * @return mixed
	 */
	private function getProject($user_id, $project_id)
	{
		return DB::table('task as T')
			// User to task
			->join(
				'user_to_task as UTT',
				'UTT.task_id',
				'=',
				'T.id'
			)

			// Get project description
			->join(
				'project_description as PD',
				'PD.project_id',
				'=',
				'T.project_id'
			)

			// Get user roles
			->join(
				'user_role as UR',
				'UR.id',
				'=',
				'UTT.user_role_id'
			)

			// Get user_role_price
			->join(
				'user_role_price as URP',
				'URP.user_role_id',
				'=',
				'UTT.user_role_id'
			)

			->select(
				'T.project_id',
				'UTT.user_id',
				'UTT.user_role_id',
				DB::raw('SUM(UTT.payed_hours) as total_payed_hours'),
				DB::raw('(SUM(UTT.payed_hours) * URP.price_per_hour_payable) as total'),
				'PD.name',
				'PD.desctiption_short',
				'UR.name',
				'URP.price_per_hour_payable'
			)

			// Filter by user and project
			->where('UTT.user_id', $user_id)
			->where('T.project_id', $project_id)

			->groupBy('UTT.user_role_id', 'URP.id')
			->get();
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
				DB::raw('(UTT.payed_hours * URP.price_per_hour) as total'),
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
	 * Get total price of all the tasks
	 *
	 * @return float
	 */
	public function calculateTotalTasksPrice($tasks)
	{
		$total = 0;

		foreach ($tasks as $task)
		{
			$total += $task->total;
		}

		return $total;
	}


	/**
	 * Get total price of all the transactions
	 *
	 * @return void
	 */
	public function calculateTotalTransactionPrice($transactions)
	{
		$total = 0;

		foreach ($transactions as $transaction)
		{
			if ($transaction->trans_is_expense)
			{
				$total += $transaction->trans_value;
			}
			else
			{
				$total -= $transaction->trans_value;
			}
		}

		return $total;
	}

}