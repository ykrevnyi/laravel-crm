<?php 


class Currency extends Eloquent {

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

}