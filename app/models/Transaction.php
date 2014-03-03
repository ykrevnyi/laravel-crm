<?php 

class Transaction extends Eloquent
{
	protected $table = 'transaction';


	/**
	 * Simply get all the transactions
	 *
	 * @return mixed
	 */
	public function getAll()
	{
		return DB::table('transaction')
			// join transaction description
			->join(
				'transaction_description', 
				'transaction.transaction_description_id', 
				'=', 
				'transaction_description.id'
			)
			// join money account
			->join(
				'money_account', 
				'transaction.transaction_to_money_account_id', 
				'=', 
				'money_account.id'
			)
			->select(
				'transaction.id AS trans_id',
				'transaction_description.name AS trans_name',
				'transaction_description.value AS trans_value',
				'transaction_description.is_expense AS trans_is_expense',
				'transaction_description.purpose AS trans_purpose',
				'money_account.name AS money_account_name'
			);
	}


	/**
	 * Store new transaction
	 *
	 * @return void
	 */
	public function createTransaction($data)
	{
		// Create new transaction description row
		$transaction_description_id = DB::table('transaction_description')
			->insertGetId(array(
				'name' => $data['name'],
				'value' => $data['price'],
				'is_expense' => $data['is_expense'],
				'purpose' => $data['purpose'],
				'created_at' => new Datetime(),
				'updated_at' => new Datetime()
			));

		// Create new transaction and relation between money account/trans_desc
		DB::table('transaction')
			->insert(array(
				'transaction_description_id' => $transaction_description_id,
				'transaction_to_money_account_id' => $data['money_account'],
				'transaction_object_type' => $data['relation'],
				'transaction_object_id' => $data['object_id'],
				'created_at' => new Datetime(),
				'updated_at' => new Datetime()
			));
	}


}