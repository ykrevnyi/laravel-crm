<?php

class TransactionPurposeController extends BaseController {


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

		$this->page['title'] = 'Управление назначениями платежей';
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$purposes = TransactionPurpose::all();

		$this->layout->content = View::make('purposes.index', compact('purposes'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->content = View::make('purposes.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$v = Validator::make(Input::all(), array(
			'name' => 'required|unique:transaction_purpose|min:2|max:20'
		));

		if ($v->fails())
		{
			return Redirect::route('transactions.purposes.create')
				->withInput()
				->withErrors($v);
		}

		$purpose = new TransactionPurpose;
		$purpose->name = Input::get('name');
		$purpose->save();

		return Redirect::route('transactions.purposes.index');
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
		$purpose = TransactionPurpose::find($id);

		$this->layout->content = View::make('purposes.edit', compact('purpose'));
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
			'name' => "required|unique:transaction_purpose,name,$id|min:2|max:20"
		));

		if ($v->fails())
		{
			return Redirect::route('transactions.purposes.edit', $id)
				->withInput()
				->withErrors($v);
		}

		$purpose = TransactionPurpose::find($id);
		$purpose->name = Input::get('name');
		$purpose->save();

		return Redirect::route('transactions.purposes.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		TransactionPurpose::find($id)->delete();

		return Redirect::route('transactions.purposes.index');
	}

}