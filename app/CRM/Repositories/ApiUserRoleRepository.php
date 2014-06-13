<?php namespace CRM\Repositories;


class ApiUserRoleRepository {


	/**
	 * Get user role list with all the prices
	 *
	 * @return mixed
	 */
	public function getList($date)
	{
		$result = array();

		// Get all roles
		$roles = \UserRole::all();

		// Loop through all the roles
		foreach ($roles as $role)
		{
			// Get role price AND filter it by date
			if ($role_price = $this->getRolePrice($role->id, $date))
			{
				$result[] = array(
					'id' => $role->id,
					'name' => $role->name,
					'price_per_hour' => $role_price->price_per_hour
				);
			}
		}

		return $result;
	}


	/**
	 * Get role price by `role_id` id AND beetween dates
	 *
	 * @return mixed
	 */
	private function getRolePrice($role_id, $date)
	{
		// Get role info
		// Give it UP! Here we are ;)
		return \DB::table('user_role_price as URP')
			->select(
				'URP.price_per_hour'
			)
			->where('URP.user_role_id', $role_id)
			->where('URP.created_at', '<', $date)
			->where('URP.deprecated_at', '>=', $date)
			->orderBy('URP.created_at', 'desc')
			->first();
	}


}