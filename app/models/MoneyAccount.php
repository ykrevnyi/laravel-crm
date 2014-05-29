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
		// Here we are storing subquery
		// This query is simply takes current currency price 
		// that depends on `created_at`
		$currency_price = "(
			SELECT `price` 
			FROM `currency_history` 
			WHERE `currency_id` = `C`.`id` 
			ORDER BY `created_at` DESC 
			LIMIT 1
		)";

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
				DB::raw($currency_price . ' as currency_price'),
				DB::raw('sum(TD.value) as transaction_total'),
				DB::raw('TRUNCATE((sum(TD.value) * ' . $currency_price . ' * MA.losses / 100), 2) as total_losses'),
				DB::raw('TRUNCATE((sum(TD.value) * ' . $currency_price . '), 2) as transaction_total_uah'),
				'MA.id as money_account_id',
				'MA.name',
				'MA.losses',
				'MA.currency_id',
				'MA.id',
				'C.unit as currency_unit',
				'C.name as currency_name'
			)

			->groupBy('MA.id')
			->get();
	}



}