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


	/**
	 * Convert dates to be human style
	 *
	 * Examle: 2014-01-01 -> today
	 *
	 * @return mixed
	 */
	public function convertDates($items, $created_at_key, $updated_at_key, $deprecated_at)
	{
		foreach ($items as $key => $item)
		{
			// Date when the project was created
			$item_created = new \Carbon\Carbon($item->$created_at_key);
			$items[$key]->$created_at_key = $this->resolveDate($item_created);

			// Resolve updated at date
			if ($updated_at_key)
			{
				$item_updated = new \Carbon\Carbon($item->$updated_at_key);
				$items[$key]->$updated_at_key = $this->resolveDate($item_updated);
			}

			// Resolve deprecated at date
			if ($deprecated_at)
			{
				$item_deprecated = new \Carbon\Carbon($item->$deprecated_at);
				$items[$key]->$deprecated_at = $this->resolveDate($item_deprecated);
			}
		}

		return $items;
	}


	/**
	 * If the project was created less then 24 hours ago
	 * we will show `today` message
	 *
	 * @return string
	 */
	public function resolveDate($item_date)
	{
		$now = \Carbon\Carbon::now();

		$translator = new Date_HumanDiff();
		$translator->setTranslator(new Date_HumanDiff_Locale_ru);

		if ( ! $item_date instanceof \Carbon\Carbon)
		{
			$item_date = new \Carbon\Carbon($item_date);
		}

		if ($item_date->diff($now)->days < 1)
		{
			return 'сегодня';
		}

		return $translator->get($item_date);
	}


	/**
	 * Here we are going to check if role deprected at date 
	 * is higher than 10 years. If it is -> we will drop this date 
	 * and will not echo it to the user
	 *
	 * @return mixed
	 */
	public function checkUserRolePeriod($items, $deprecated_at_key)
	{
		$now = \Carbon\Carbon::now();

		foreach ($items as $key => $item)
		{
			// Date when the project was created
			$item_deprecated = new \Carbon\Carbon($item->$deprecated_at_key);

			if ($item_deprecated->diffInYears($now) > 10)
			{
				$items[$key]->$deprecated_at_key = null;
			}
		}

		return $items;
	}


}