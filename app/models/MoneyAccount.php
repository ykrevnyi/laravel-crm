<?php 


class MoneyAccount extends Eloquent
{
	protected $table = 'money_account';


	/**
	 * Get list of money account with money balance on it
	 *
	 * @return mixed
	 */
	public function getList()
	{
		return DB::table('money_account as MA')
			// Join related transactions
			->join(
				'transaction as T',
				'T.transaction_to_money_account_id',
				'=',
				'MA.id'
			)

			// Join transaction description
			->join(
				'transaction_description as TD',
				'TD.transaction_id',
				'=',
				'T.id'
			)

			->select(
				DB::raw('sum(TD.value) as transaction_total'),
				'MA.id as money_account_id',
				'MA.name'
			)

			->groupBy('MA.id')
			->get();
	}



}