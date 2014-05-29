<?php

class CurrencyController extends BaseController {


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

		$this->page['title'] = 'Управление валютами';
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$currencies = Currency::all();

		$this->layout->content = View::make('currencies.index', compact('currencies'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->layout->content = View::make('currencies.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$v = Validator::make(Input::all(), array(
			'name' => 'required|unique:currencies|min:2|max:20',
			'unit' => 'required',
			'price' => 'required',
		));

		if ($v->fails())
		{
			return Redirect::route('currencies.create')
				->withInput()
				->withErrors($v);
		}

		$currency = new Currency;
		$currency->name = Input::get('name');
		$currency->unit = Input::get('unit');
		$currency->price = Input::get('price');
		$currency->save();

		return Redirect::route('currencies.index');
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
	 *,
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$currency = Currency::find($id);

		$this->layout->content = View::make('currencies.edit', compact('currency'));
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
			'name' => "required|unique:currencies,name,$id|min:2|max:20",
			'unit' => 'required',
			'price' => 'required'
		));

		if ($v->fails())
		{
			return Redirect::route('currencies.edit', $id)
				->withInput()
				->withErrors($v);
		}

		$currency = Currency::find($id);
		$currency->name = Input::get('name');
		$currency->unit = Input::get('unit');
		$currency->price = Input::get('price');
		$currency->save();

		return Redirect::route('currencies.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Currency::find($id)->delete();

		return Redirect::route('currencies.index');
	}

}