<?php 

class Project extends Eloquent
{

	function __construct() {}


	/**
	 * Get all project list
	 *
	 * @return void
	 */
	public function getProjects($date_from = NULL, $date_to = NULL, $filter_name = NULL)
	{
		$result = DB::table('project as P')
			// Join project description
			->join(
				'project_description as PD',
				'PD.project_id',
				'=',
				'P.id'
			)

			// Join project priorities values
			->join(
				'project_priority as PP',
				'P.project_priority_id',
				'=',
				'PP.id'
			)

			// Get selected info
			->select(
				'P.id as proj_id',
				'P.status as proj_status',
				'P.done_percents as proj_persents',
				'P.end_date as proj_end_date',
				'P.created_at as proj_created_at',
				'P.updated_at as proj_updated_at',

				'PD.name as proj_name',
				'PD.desctiption_short as proj_desc_short',
				'PD.description as proj_desc',
				
				'PP.name as proj_priority_name',
				'PP.color as proj_priority_color'
			)
			->orderBy('P.created_at', 'desc');


		// TODO: add filter via Closure (like in transactions)
		// Filter `date from`
		if ( ! is_null($date_from))
		{
			$result->where('P.created_at', '>=', $date_from->format('Y-m-d'));
		}

		// Filter `date to`
		if ( ! is_null($date_to))
		{
			$result->where('P.created_at', '<=', $date_to->format('Y-m-d'));
		}

		// Filter `project name`
		if ( ! is_null($filter_name))
		{
			$result->where('PD.name', 'LIKE', '%' . $filter_name . '%');
		}

		return $result->get();
	}


	/**
	 * Get full project info
	 *
	 * @return mixed
	 */
	public function getProjectInfo($project_id)
	{
		return DB::table('project as P')
			// Join project description
			->join(
				'project_description as PD',
				'PD.project_id',
				'=',
				'P.id'
			)

			// Join project priorities values
			->join(
				'project_priority as PP',
				'P.project_priority_id',
				'=',
				'PP.id'
			)

			// Get selected info
			->select(
				'P.id as proj_id',
				'P.status as proj_status',
				'P.done_percents as proj_persents',
				'P.end_date as proj_end_date',
				'P.created_at as proj_created_at',
				'P.updated_at as proj_updated_at',

				'PD.name as proj_name',
				'PD.desctiption_short as proj_desc_short',
				'PD.description as proj_desc',
				
				'PP.id as proj_priority_id',
				'PP.name as proj_priority_name',
				'PP.color as proj_priority_color'
			)
			->where('P.id', '=', $project_id)
			->first();
	}


	/**
	 * Get users that are related to the project with all hours
	 * `projects.show` 3rd tab.
	 *
	 * @return mixed
	 */
	public function getRelatedUsers($project_id)
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
				DB::raw('TRUNCATE(UTT.payed_hours, 2) as payed_hours'),
				'U.email AS user_email',
				'U.email AS user_email',
				'UR.name as role_name',
				'URP.price_per_hour as period_price_per_hour',
				DB::raw('TRUNCATE((UTT.payed_hours * URP.price_per_hour), 2) as period_total_price'),
				'URP.created_at as period_created_at',
				'URP.deprecated_at as period_deprecated_at'
			)
			->where('T.project_id', '=', $project_id)
			->where('UR.percents', '0')

			->whereRaw('T.created_at >= URP.created_at')
			->whereRaw('T.created_at < URP.deprecated_at')

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
	 * Get the total hours of all the related users roles
	 * 
	 * Senior developer -> 200$ (total to the project)
	 * Developer -> 300$ (total to the project)
	 * 
	 * `projects.show` 2nd tab.
	 *
	 * @return mixed
	 */
	public function getRelatedUsersTotal($project_id)
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
				DB::raw('TRUNCATE(UTT.payed_hours, 2) as payed_hours'),
				'U.email AS user_email',
				'U.email AS user_email',
				'UR.name as role_name',
				'URP.price_per_hour as period_price_per_hour',
				DB::raw('TRUNCATE(SUM(UTT.payed_hours * URP.price_per_hour), 2) as period_total_price'),
				'URP.created_at as period_created_at',
				'URP.deprecated_at as period_deprecated_at'
			)
			->where('T.project_id', '=', $project_id)

			->whereRaw('T.created_at >= URP.created_at')
			->whereRaw('T.created_at < URP.deprecated_at')

			->groupBy('UTT.user_role_id')

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
	 * Get retaled transactions
	 *
	 * @return mixed
	 */
	public function getRelatedTransacitons($project_id)
	{
		$transaction = new Transaction();

		$transaction_ids_rs = DB::table('transaction')
			->where('transaction_object_type', '=', 'project')
			->where('transaction_object_id', '=', $project_id)
			->select('id')
			->get();

		// Check if there are some transactions
		if (empty($transaction_ids_rs))
		{
			return array();
		}

		// Convert result to the simple list of id's
		$transaction_ids = array_pluck($transaction_ids_rs, 'id');

		// Get transaction info
		$transaction_list = $transaction->getAll(
			function($query) use ($transaction_ids) {
				return $query->whereIn('transaction.id', $transaction_ids);
			}
		)->get();

		return $transaction_list;
	}

	
	/**
	 * Create new project
	 *
	 * @return int
	 */
	public function createProject($project_info = array())
	{
		// Update simple project info
		$project_id = DB::table('project')
			->insertGetId(array(
				'status' => $project_info['proj_status'],
				'project_priority_id' => $project_info['proj_priority_id'],
				'done_percents' => $project_info['proj_persents'],
				'end_date' => $project_info['proj_end_date'],
				'created_at' => \Carbon\Carbon::now(),
				'updated_at' => \Carbon\Carbon::now()
			));

		// Update project description info
		DB::table('project_description')
			->insert(array(
				'project_id' => $project_id,
				'name' => $project_info['proj_name'],
				'desctiption_short' => $project_info['proj_desc_short'],
				'description' => $project_info['proj_desc']
			));

		// Aaaand re-append new users to the project
		$users_to_append = array();

		// Check if users are specified
		if ( ! empty($project_info['related_users']))
		{
			foreach ($project_info['related_users'] as $related_user_id)
			{
				$users_to_append[] = array(
					'project_id' => $project_id,
					'user_id' => $related_user_id
				);
			}

			DB::table('user_to_project')->insert($users_to_append);
		}

		return $project_id;
	}


	/**
	 * Save project data
	 *
	 * @return void
	 */
	public function saveProject($project_info = array(), $project_id)
	{
		// Update simple project info
		DB::table('project')
			->where('id', '=', $project_id)
			->update(array(
				'status' => $project_info['proj_status'],
				'project_priority_id' => $project_info['proj_priority_id'],
				'done_percents' => $project_info['proj_persents'],
				'end_date' => $project_info['proj_end_date'],
				'updated_at' => \Carbon\Carbon::now()
			));

		// Update project description info
		DB::table('project_description')
			->where('project_id', '=', $project_id)
			->update(array(
				'name' => $project_info['proj_name'],
				'desctiption_short' => $project_info['proj_desc_short'],
				'description' => $project_info['proj_desc']
			));
	}


	/**
	 * Remove project by id
	 *
	 * @return void
	 */
	public function remove($project_id)
	{
		DB::table('project')->where('id', $project_id)->delete();
	}


	/**
	 * Add user to the project
	 *
	 * @return void
	 */
	public function addUserToProject($project_id, $user_id, $user_role_id, $user_payed_hours)
	{
		if ($this->findUserWithParams($project_id, $user_id, $user_role_id) 
			OR ! $project_id OR ! $user_id OR ! $user_role_id)
		{
			return false;
		}

		DB::table('user_to_project')->insert(array(
			'project_id' => $project_id,
			'user_id' => $user_id,
			'payed_hours' => $user_payed_hours,
			'user_role_id' => $user_role_id
		));

		return true;
	}


	/**
	 * Remove user from the project
	 *
	 * @return void
	 */
	public function removeUserFromProject($project_id, $user_id, $user_role_id)
	{
		if ( ! $project_id OR ! $user_id OR ! $user_role_id)
		{
			return false;
		}

		DB::table('user_to_project')
			->where('project_id', '=', $project_id)
			->where('user_id', '=', $user_id)
			->where('user_role_id', '=', $user_role_id)
			->delete();

		return true;
	}


	/**
	 * Change user to project role
	 *
	 * @return void
	 */
	public function changeUserProjectRole($project_id, $user_id, $user_role_id, $prev_user_role_id)
	{
		if ($this->findUserWithParams($project_id, $user_id, $user_role_id) 
			OR ! $project_id OR ! $user_id OR ! $user_role_id OR ! $prev_user_role_id)
		{
			return false;
		}

		DB::table('user_to_project')
			->where('project_id', '=', $project_id)
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
	public function changeUserProjectPayedHours($project_id, $user_id, $user_role_id, $user_payed_hours)
	{
		if ($user_payed_hours < 0)
		{
			$user_payed_hours = 0;
		}

		DB::table('user_to_project')
			->where('project_id', '=', $project_id)
			->where('user_id', '=', $user_id)
			->where('user_role_id', '=', $user_role_id)
			->update(array(
				'payed_hours' => $user_payed_hours
			));

		return true;
	}


	/**
	 * Here we are going to check if user (in project) with passed data already exists
	 *
	 * @return bool
	 */
	private function findUserWithParams($project_id, $user_id, $user_role_id)
	{
		$result = DB::table('user_to_project')
			->where('project_id', '=', $project_id)
			->where('user_id', '=', $user_id)
			->where('user_role_id', '=', $user_role_id)
			->first();

		return !! $result;
	}


}