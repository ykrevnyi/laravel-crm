<?php namespace CRM\Controllers;


use View;


class ReportsController extends \BaseController {

	
	private $transaction;


	function __construct() {
		$this->transaction = new \Transaction;
	}


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

		$this->page['title'] = 'User list page';
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$results = array();

		// Current month
		$date_start = \Carbon\Carbon::create();
		$date_end = \Carbon\Carbon::create();

		$date_start = $date_start->startOfMonth();
		$date_end = $date_end->endOfMonth();

		for ($i=0; $i < 6; $i++)
		{
			if ($i)
			{
				$date_start = $date_start->subMonth();
				$date_end = $date_end->startOfMonth()->subMonth()->endOfMonth();
			}

			// Get transactions in time period
			$transactions = $this->transaction->getAll(
				function($query) use ($date_start, $date_end) {
					return $query
						->whereBetween(
							'transaction.created_at', 
							array(
								$date_start->format('Y-m-d'),
								$date_end->format('Y-m-d')
							)
						);
				}
			)->get();

			// Calculate total
			$profit = $this->transaction->calculateProfit($transactions);
			$expence = $this->transaction->calculateExpence($transactions);

			// Store reports result
			$results[] = array(
				'date_from' => $date_start->format('Y-m-d'),
				'date_to' => $date_end->format('Y-m-d'),
				'month_name' => rudate('F', $date_end, true),
				'profit' => $profit,
				'expence' => $expence
			);
		}

		// Reverse array in order to get incrementing month order
		$results = array_reverse($results);

		$this->layout->content = View::make('reports.index', compact('results'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}