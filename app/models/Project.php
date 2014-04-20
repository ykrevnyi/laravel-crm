<?php 

class Project extends Eloquent
{
	
	private $redmineUser;


	function __construct(RedmineUser $user) {
		$this->redmineUser = $user;
	}


	/**
	 * Get all project list
	 *
	 * @return void
	 */
	public function getProjects()
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
				'P.price as proj_price',
				'P.price_per_hour as proj_price_per_hour',
				'P.billed_hours as proj_billed_hours',
				'P.actual_hours as proj_actual_hours',
				'P.end_date as proj_end_date',
				'P.created_at as proj_created_at',
				'P.updated_at as proj_updated_at',

				'PD.name as proj_name',
				'PD.desctiption_short as proj_desc_short',
				'PD.description as proj_desc',
				
				'PP.name as proj_priority_name',
				'PP.color as proj_priority_color'
			)
			->orderBy('P.created_at', 'desc')
			->get();
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
				'P.price as proj_price',
				'P.price_per_hour as proj_price_per_hour',
				'P.billed_hours as proj_billed_hours',
				'P.actual_hours as proj_actual_hours',
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
	 * Get users that are related to the project
	 *
	 * @return mixed
	 */
	public function getRelatedUsers($project_id)
	{
		// Get related user ids + related role ids
		$related_user_ids = DB::table('user_to_project')
			->where('project_id', '=', $project_id)
			->select('user_id', 'user_role_id', 'payed_hours')
			->get();

		// Get users information
		$users = array();

		foreach ($related_user_ids as $user)
		{
			$local_user = User::find($user->user_id);
			$newUser = $this->redmineUser->getRedmineUser($local_user->email);
			$newUser->id = $local_user->id;
			$newUser->payed_hours = $user->payed_hours;
			$newUser->user_role_id = $user->user_role_id;
			
			$users[] = $newUser;
		}
		
		return $users;
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
		)
		->get();

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
				'price' => $project_info['proj_price'],
				'price_per_hour' => $project_info['proj_price_per_hour'],
				'billed_hours' => $project_info['proj_billed_hours'],
				'actual_hours' => $project_info['proj_actual_hours'],
				'end_date' => $project_info['proj_end_date'],
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
				'price' => $project_info['proj_price'],
				'price_per_hour' => $project_info['proj_price_per_hour'],
				'billed_hours' => $project_info['proj_billed_hours'],
				'actual_hours' => $project_info['proj_actual_hours'],
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