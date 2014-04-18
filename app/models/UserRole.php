<?php 

class UserRole extends Eloquent
{
	protected $table = 'user_role';


	/**
	 * Simply convert array to be $key => $value
	 * For <select>
	 *
	 * @return mixed
	 */
	public function scopeAllForSelect()
	{
		$result = array();

		foreach (self::all()->toArray() as $key => $value)
		{
			$result[$value['id']] = $value['name'];
		}

		return $result;
	}
}