<?php 

class ProjectPriority extends Eloquent
{

	protected $table = 'project_priority';


	/**
	 * Convert Eloquent style object into the Form::select style
	 *
	 * @return mixed
	 */
	public function scopeGetAllConvertedToView()
	{
		$all = self::all();
		$result = array();

		foreach ($all as $priority)
		{
			$result[$priority->id] = $priority->name;
		}

		return $result;
	}

}