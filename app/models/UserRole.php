<?php 

class UserRole extends Eloquent
{
	protected $table = 'user_role';
	protected $guarded = array();


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


	/**
	 * Get single role info
	 *
	 * @return mixed
	 */
	public function getRole($role_id)
	{
		$role_info = self::find($role_id);
		$role_price = $this->getRolePrice($role_id);

		return array(
			'id' => $role_info->id,
			'name' => $role_info->name,
			'percents' => $role_info->percents,
			'price_per_hour' => $role_price->price_per_hour,
			'price_per_hour_payable' => $role_price->price_per_hour_payable
		);
	}


	/**
	 * Get user role list with all the prices
	 *
	 * @return mixed
	 */
	public function getList()
	{
		$roles = self::all();
		$list = array();

		foreach ($roles as $role)
		{
			$role_price = $this->getRolePrice($role->id);

			$list[] = array(
				'id' => $role->id,
				'name' => $role->name,
				'price_per_hour' => $role_price->price_per_hour,
				'price_per_hour_payable' => $role_price->price_per_hour_payable
			);
		}

		return $list;
	}


	/**
	 * Get the latest role price by `role_id` id
	 *
	 * @return mixed
	 */
	private function getRolePrice($role_id)
	{
		return DB::table('user_role_price as URP')
			->select(
				'URP.price_per_hour',
				'URP.price_per_hour_payable'
			)
			->where('URP.user_role_id', $role_id)
			->orderBy('URP.created_at', 'desc')
			->first();
	}


	/**
	 * Store newly created role
	 *
	 * @return void
	 */
	public function createRole($data)
	{
		// Check if user has percents
		if ( ! empty($data['percents']) AND $data['percents'] == 'Y')
		{
			$data['percents'] = 1;
		}
		else
		{
			$data['percents'] = 0;
		}

		// Store basic user role and get its id
		$role_id = DB::table('user_role')
			->insertGetId(array(
				'name' => $data['name'],
				'percents' => $data['percents'],
				'created_at' => \Carbon\Carbon::now(),
				'updated_at' => \Carbon\Carbon::now()
			));

		// Store role prices
		DB::table('user_role_price')
			->insert(array(
				'user_role_id' => $role_id,
				'price_per_hour' => $data['price_per_hour'],
				'price_per_hour_payable' => $data['price_per_hour_payable'],
				'created_at' => \Carbon\Carbon::now()
			));
	}


	public function updateRole($role_id, $data)
	{
		$date = \Carbon\Carbon::now();

		// Check if user has percents
		if ( ! empty($data['percents']) AND $data['percents'] == 'Y')
		{
			$data['percents'] = 1;
		}
		else
		{
			$data['percents'] = 0;
		}

		// Update basic role info
		$role = self::find($role_id);
		$role->name = $data['name'];
		$role->percents = $data['percents'];
		$role->save();

		// Set new deprecated status to the latest role price
		DB::table('user_role_price')
			->where('user_role_id', $role_id)
			->orderBy('created_at', 'desc')
			->take(1)
			->update(array(
				'deprecated_at' => $date
			));

		// Store role prices
		DB::table('user_role_price')
			->insert(array(
				'user_role_id' => $role_id,
				'price_per_hour' => $data['price_per_hour'],
				'price_per_hour_payable' => $data['price_per_hour_payable'],
				'created_at' => $date
			));
	}


	/**
	 * Get price change history of specified role
	 *
	 * @return mixed
	 */
	public function getPriceHistory($role_id)
	{
		$prise_history = DB::table('user_role_price')
			->where('user_role_id', $role_id)
			->groupBy('created_at', 'user_role_id')
			->orderBy('created_at')
			->get();

		return $prise_history;
	}


	/**
	 * Remove user role
	 *
	 * @return void
	 */
	public function remove($role_id)
	{
		self::find($role_id)->delete();

		DB::table('user_role_price')
			->where('user_role_id', $role_id)
			->delete();
	}


}