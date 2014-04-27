<?php

class PrioritiesController extends BaseController {


	public function before() {}


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

		$this->page['title'] = 'Управление приоритетами';
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$priorities = ProjectPriority::all();

		$this->layout->content = View::make('priorities.index', compact('priorities'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->content = View::make('priorities.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$v = Validator::make(Input::all(), array(
			'name' => 'required|alpha_dash',
			'color' => 'required'
		));

		if ($v->fails())
		{
			return Redirect::route('priorities.create')
				->withInput()
				->withErrors($v);
		}

		$priority = new ProjectPriority;
		$priority->name = Input::get('name');
		$priority->color = Input::get('color');
		$priority->save();

		return Redirect::route('priorities.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$priority = ProjectPriority::find($id);

		$this->layout->content = View::make('priorities.edit', compact('priority'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$v = Validator::make(Input::all(), array(
			'name' => 'required|alpha_dash',
			'color' => 'required'
		));

		if ($v->fails())
		{
			return Redirect::route('priorities.edit', $id)
				->withInput()
				->withErrors($v);
		}

		$priority = ProjectPriority::find($id);
		$priority->name = Input::get('name');
		$priority->color = Input::get('color');
		$priority->save();

		return Redirect::route('priorities.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		ProjectPriority::find($id)->delete();

		return Redirect::route('priorities.index');
	}

}