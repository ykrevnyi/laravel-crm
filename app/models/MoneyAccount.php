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

			// Join currencies
			->join(
				'currencies as C',
				'C.id',
				'=',
				'MA.currency_id'
			)

			->select(
				DB::raw('sum(TD.value) as transaction_total'),
				DB::raw('(sum(TD.value) * C.price * MA.losses / 100) as total_losses'),
				DB::raw('(sum(TD.value) * C.price) as transaction_total_uah'),
				'MA.id as money_account_id',
				'MA.name',
				'MA.losses',
				'MA.currency_id',
				'MA.id',
				'C.unit as currency_unit',
				'C.name as currency_name',
				'C.price as currency_price'
			)

			->groupBy('MA.id')
			->get();
	}



}