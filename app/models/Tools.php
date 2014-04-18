<?php 


class Tools extends Eloquent 
{
	

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