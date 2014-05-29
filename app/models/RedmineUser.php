<?php


/**
* Try to auth user via redmine database
*/
class RedmineUser extends Eloquent
{

	public static $userData = NULL;


	/**
	 * Simply get user by id
	 *
	 * @return mixed
	 */
	public function scopeGetById($obj, $user_id)
	{
		$locaUserInfo = DB::table('users')->where('id', '=', $user_id)->first();
		$redmineUser = self::getRedmineUser($locaUserInfo->email);

		// Set needle params
		$redmineUser->perm = $locaUserInfo->perm;
		$redmineUser->id = $locaUserInfo->id;

		$redmineUser = $this->setUserStatuses($redmineUser);

		return $redmineUser;
	}


	/**
	 * Get list of all the users in system (redmine and local db)
	 *
	 * @return mixed
	 */
	public function getAllWithPaginations($paginate = 10)
	{
		$resultUsers = array();

		$localUsers = User::paginate($paginate);
		$redmineUsers = DB::connection('redmine')->table('users')->get();

		// Now we are going to merge users depends on their emails
		$resultUsers = $this->mergeUserTypes($redmineUsers, $localUsers);

		return array(
			'users' => $resultUsers,
			'links' => $localUsers->links()
		);
	}


	/**
	 * Merge redmine and local users
	 * Local user have greater priority then redmine users
	 *
	 * @return mixed
	 */
	private function mergeUserTypes($redmineUsers = array(), $localUsers)
	{
		$resultUsers = array();

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

		return $resultUsers;
	}


	/**
	 * Auth user via redmine and local database
	 *
	 * @return bool
	 */
	public function auth($credentials)
	{
		// Get redmine user info
		$redmineUser = self::getRedmineUser($credentials['email']);

		// There no user in redmine at all
		if (isset($redmineUser->id) AND $redmineUser->id)
		{
			// Ok, redmine has that user
			// Now we should check credentials
			$inputPassword = sha1($redmineUser->salt . sha1($credentials['password']));

			// Check passwords
			if ($redmineUser->hashed_password === $inputPassword)
			{
				$this->authLocalUser($redmineUser);

				return true;
			}
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
	public function scopeGetRedmineUser($query, $email)
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

		// If user is not authed
		if ( ! $localUser)
		{
			return NULL;
		}

		$remineUser = self::getRedmineUser($localUser->email);

		$localUser = $this->populateUserData($localUser, $remineUser);
		$localUser = $this->setUserStatuses($localUser);

		static::$userData = $localUser;
	}	


	static public function user()
	{
		return static::$userData;
	}

}