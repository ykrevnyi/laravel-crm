<?php 


class Currency extends Eloquent {

	public $timestamps = false;
	protected $table = 'currencies';


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
	 * Get single currency info
	 *
	 * @return mixed
	 */
	public function getCurrency($currency_id)
	{
		$currency_info = self::find($currency_id);
		$currency_price = $this->getCurrencyPrice($currency_id);

		return array(
			'id' => $currency_info->id,
			'name' => $currency_info->name,
			'unit' => $currency_info->unit,
			'price' => $currency_price->price
		);
	}


	/**
	 * Get currency list with all the prices
	 *
	 * @return mixed
	 */
	public function getList()
	{
		$currencies = self::all();
		$list = array();

		foreach ($currencies as $currency)
		{
			$currency_price = $this->getCurrencyPrice($currency->id);

			$list[] = array(
				'id' => $currency->id,
				'name' => $currency->name,
				'price' => $currency_price->price
			);
		}

		return $list;
	}


	/**
	 * Create new currency
	 *
	 * @return void
	 */
	public function createCurrency($data)
	{
		// Store basic user currency and get its id
		$currency_id = DB::table('currencies')
			->insertGetId(array(
				'name' => $data['name'],
				'unit' => $data['unit']
			));

		// Store currency prices
		DB::table('currency_history')
			->insert(array(
				'currency_id' => $currency_id,
				'price' => $data['price'],
				'created_at' => \Carbon\Carbon::now()
			));
	}


	/**
	 * Set `deprecated_at` field to NOW() of latest field.
	 * And create new one with `deprecated_at` equals '' 
	 * (mysql default value is 2099-01-01)
	 *
	 * @return void
	 */
	public function updateCurrency($currency_id, $data)
	{
		$date = \Carbon\Carbon::now();

		$currency = self::find($currency_id);
		$currency->name = $data['name'];
		$currency->unit = $data['unit'];
		$currency->save();

		// Set new deprecated status to the latest currency price
		DB::table('currency_history')
			->where('currency_id', $currency_id)
			->orderBy('created_at', 'desc')
			->take(1)
			->update(array(
				'deprecated_at' => $date
			));

		// Store currency prices
		DB::table('currency_history')
			->insert(array(
				'currency_id' => $currency_id,
				'created_at' => $date,
				'price' => $data['price']
			));
	}


	/**
	 * Simply here are going to get currency price
	 * that depends on created_at and deprecated_at
	 *
	 * @return mixed
	 */
	public function getCurrencyPrice($currency_id)
	{
		return DB::table('currency_history as CH')
			->select(
				'CH.price'
			)
			->where('CH.currency_id', $currency_id)
			->orderBy('CH.created_at', 'desc')
			->first();
	}


}