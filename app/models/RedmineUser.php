<?php


/**
* Try to auth user via redmine database
*/
class RedmineUser extends Eloquent
{

	public static $userData = NULL;


	/**
	 * Simply get list of all the users in system (redmine and local db)
	 *
	 * @return mixed
	 */
	public function getAllWithPaginations($paginate = 10)
	{
		$resultUsers = array();

		$localUsers = User::paginate($paginate);
		$redmineUsers = DB::connection('redmine')->table('users')->get();

		// Now we are going to merge users depends on their emails
		foreach ($localUsers as $key => $localUser)
		{
			foreach ($redmineUsers as $redmineUser)
			{
				if ($localUser['email'] == $redmineUser->mail)
				{
					$redmineUser->perm = $localUser['perm'];
					$redmineUser->id = $localUser['id'];

					$redmineUser = $this->setUserStatuses($redmineUser);
					$resultUsers[] = $redmineUser;

					break;
				}
			}
		}

		return array(
			'users' => $resultUsers,
			'links' => $localUsers->links()
		);
	}


	/**
	 * Auth user via redmine and local database
	 *
	 * @return bool
	 */
	public function auth($credentials)
	{
		// Get redmine user info
		$redmineUser = $this->getRedmineUser($credentials['email']);

		// There no user in redmine at all
		if (empty($redmineUser))
		{
			return false;
		}

		// Ok, redmine has that user
		// Now we should check credentials
		$inputPassword = sha1($redmineUser->salt . sha1($credentials['password']));

		// Check passwords
		if ($redmineUser->hashed_password === $inputPassword)
		{
			$this->authLocalUser($redmineUser);
			$this->populateUserData($redmineUser);
			$this->setUserStatuses();

			return true;
		}

		return false;
	}


	/**
	 * Auth local user
	 *
	 * @return void
	 */
	private function authLocalUser($redmineUser)
	{
		// Check if local user already exits
		$localUser = $this->getLocalUserID($redmineUser->mail);
		$localUserID = empty($localUser->id) ? NULL : $localUser->id;

		// If exists ---> login him
		if (is_null($localUserID))
		{
			$localUserID = DB::table('users')->insertGetId(array(
				'email' => $redmineUser->mail
			));
		}

		// Login user
		Auth::loginUsingId($localUserID);
	}


	/**
	 * Add redmine user info to the local auth user
	 *
	 * @return void
	 */
	private function populateUserData($localUser, $redmineUser)
	{
		foreach ($redmineUser as $key => $value)
		{
			$localUser[$key] = $value;
		}

		return $localUser;
	}


	/**
	 * Set user statuset to be like 'admin', 'guest', 'teammate'
	 *
	 * @return void
	 */
	private function setUserStatuses($localUser)
	{
		switch ($localUser->perm)
		{
			case 500:
				$localUser->level = 'teammate';
			break;

			case 5000:
				$localUser->level = 'admin';
			break;

			default:
				$localUser->level = 'users';
			break;
		}

		return $localUser;
	}


	/**
	 * Get redmine user by email
	 *
	 * @return mixed
	 */
	private function getRedmineUser($email)
	{
		return DB::connection('redmine')
			->table('users')
			->where('mail', '=', $email)
			->first();
	}


	/**
	 * Check if local user exists
	 *
	 * @return mixed
	 */
	private function getLocalUserID($email)
	{
		return DB::table('users')
			->where('email', '=', $email)
			->first();
	}


	/**
	 * Get current user info
	 *
	 * @return mixed
	 */
	public function getUserInfo()
	{
		$localUser = Auth::user();
		$remineUser = $this->getRedmineUser($localUser->email);

		$localUser = $this->populateUserData($localUser, $remineUser);
		$localUser = $this->setUserStatuses($localUser);

		static::$userData = $localUser;
	}	


	static public function user()
	{
		return static::$userData;
	}

}