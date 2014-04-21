<?php 


class Tools extends Eloquent 
{

	private $month_replase = array(
		'Января' => 'January',
		'Февраля' => 'February',
		'Марта' => 'March',
		'Апреля' => 'April',
		'Мая' => 'May',
		'Июня' => 'June',
		'Июля' => 'July',
		'Августа' => 'August',
		'Сентября' => 'September',
		'Октября' => 'October',
		'Ноября' => 'November',
		'Декабря' => 'December'
	);
	

	public function scopeConvertProjectToSelectable($obj, $project_list)
	{
		$result = array();

		foreach ($project_list as $key => $project)
		{
			$result[$project->proj_id] = $project->proj_name;
		}

		return $result;
	}


}