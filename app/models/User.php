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
	public function getUserProjects($user_id)
	{
		$user_related_projects = DB::table('user_to_task as UTT')
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
			->where('UTT.user_id', $user_id)
			->groupBy('T.project_id')
			->get();

		// Get detail project info
		foreach ($user_related_projects as & $project)
		{
			$project_info = $this->getProject($user_id, $project->project_id);

			// Get total price of the project
			$total_price = 0;
			foreach ($project_info as $project_info_item)
			{
				$total_price += $project_info_item->total;
			}

			$project = (array) $project;
			$project['total_price'] = $total_price;
			$project = (object) $project;

			$project->info = $project_info;
		}
		
		return $user_related_projects;
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

}