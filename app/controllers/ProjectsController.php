<?php

class ProjectsController extends BaseController {

	protected $project, $redmineUser;

	public function before() {
		$this->redmineUser = new RedmineUser;
		$this->project = new Project($this->redmineUser);
	}

	/**
	 * Create default view parts
	 *
	 * @return void
	 */
	protected function beforeRender()
	{
		parent::beforeRender();

		// Bind header and footer
		$this->layout->header = View::make('admin.common.header', $this->page);
		$this->layout->footer = View::make('admin.common.footer', $this->page);

		$this->page['title'] = 'User list page';
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$project_list = $this->project->getProjects();

		$this->layout->content = View::make('projects.index', compact('project_list'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Get all the project priorities
		$priorities = ProjectPriority::getAllConvertedToView();

		// Fetch all the users
		$all_users = $this->redmineUser->getAllWithPaginations();
		$users = $this->getSelectedUsers($all_users['users'], array());

		$this->layout->content = View::make('projects.create')
			->with('users', $users)
			->with('priorities', $priorities);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->project->createProject(Input::all());
		
		return Redirect::route('projects.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($project_id)
	{
		// Basic project info
		$project = $this->project->getProjectInfo($project_id);

		// Get related users
		$related_users = $this->project->getRelatedUsers($project_id);

		// Get related transactions
		$related_transactions = $this->project->getRelatedTransacitons($project_id);

		$this->layout->content = View::make('projects.show')
			->with('project', $project)
			->with('related_users', $related_users)
			->with('transactions', $related_transactions);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($project_id)
	{
		// Basic project info
		$project = $this->project->getProjectInfo($project_id);

		// Get all the project priorities
		$priorities = ProjectPriority::getAllConvertedToView();

		// Get related users
		$related_users = $this->project->getRelatedUsers($project_id);

		// Fetch all the users
		$all_users = $this->redmineUser->getAllWithPaginations();
		$users = $this->getSelectedUsers($all_users['users'], $related_users);
		
		// Get related transactions
		$related_transactions = $this->project->getRelatedTransacitons($project_id);

		$this->layout->content = View::make('projects.edit')
			->with('project', $project)
			->with('users', $users)
			->with('priorities', $priorities)
			->with('transactions', $related_transactions);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($project_id)
	{
		// print_r(Input::all()); die();
		$this->project->saveProject(Input::all(), $project_id);
		
		return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($project_id)
	{
		$this->project->remove($project_id);

		return Redirect::route('projects.index');
	}

	/**
	 * Get selected users
	 *
	 * @return mixed
	 */
	private function getSelectedUsers($all_users = array(), $related_users = array())
	{
		$all_users_ids = array();
		$selected_users_ids = array();

		foreach ($all_users as $user)
		{
			$all_users_ids[$user->id] = $user->firstname . ' ' . $user->lastname;

			foreach ($related_users as $related_user)
			{
				if ($user->id == $related_user->id)
				{
					$selected_users_ids[] = $user->id;
				}
			}
		}

		return array(
			'all' => $all_users_ids,
			'selected' => $selected_users_ids
		);
	}

}