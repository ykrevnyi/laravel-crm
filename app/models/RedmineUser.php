<?php


/**
* Try to auth user via redmine database
*/
class RedmineUser extends Eloquent
{


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

}