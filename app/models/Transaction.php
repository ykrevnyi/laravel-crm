<?php 

class Transaction extends Eloquent
{
	protected $table = 'transaction';


	/**
	 * Simply get all the transactions
	 *
	 * @return mixed
	 */
	public function getAll($filter = null)
	{
		$transactions = DB::table('transaction')
			// join transaction description
			->join(
				'transaction_description', 
				'transaction.id', 
				'=', 
				'transaction_description.transaction_id'
			)
			// join transaction purpose
			->join(
				'transaction_purpose', 
				'transaction_description.transaction_purpose_id', 
				'=', 
				'transaction_purpose.id'
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
				'transaction.created_at AS trans_created_at',
				'transaction.updated_at AS trans_updated_at',
				'transaction_description.name AS trans_name',
				'transaction_description.value AS trans_value',
				'transaction_description.is_expense AS trans_is_expense',
				'transaction_purpose.name AS trans_purpose',
				'money_account.name AS money_account_name'
			)
			->orderBy('trans_id', 'desc');

			if ($filter)
			{
				$transactions->where($filter);
			}

			return $transactions;
	}


	/**
	 * Store new transaction
	 *
	 * @return void
	 */
	public function createTransaction($data)
	{
		// Create new transaction and relation between money account/trans_desc
		$transaction_id = DB::table('transaction')
			->insertGetId(array(
				'transaction_to_money_account_id' => $data['money_account'],
				'transaction_object_type' => $data['relation'],
				'transaction_object_id' => $data['object_id'],
				'created_at' => new Datetime(),
				'updated_at' => new Datetime()
			));

		// Create new transaction description row
		$transaction_description_id = DB::table('transaction_description')
			->insertGetId(array(
				'name' => $data['name'],
				'transaction_id' => $transaction_id,
				'transaction_purpose_id' => $data['transaction_purpose_id'],
				'value' => $data['price'],
				'is_expense' => $data['is_expense'],
				'created_at' => new Datetime(),
				'updated_at' => new Datetime()
			));
	}


	/**
	 * Remove transaction by id
	 *
	 * @return void
	 */
	public function removeByID($transaction_id)
	{
		// Remove basic transaction
		// Other transaction info will be removed by cascade strategy
		return DB::table('transaction')->where('id', '=', $transaction_id)->delete();
	}


	/**
	 * Get total price of al the transactions
	 *
	 * @return void
	 */
	public function calculateTotal($transactions)
	{
		$total = 0;

		foreach ($transactions as $transaction)
		{
			if ($transaction->trans_is_expense)
			{
				$total -= $transaction->trans_value;
			}
			else
			{
				$total += $transaction->trans_value;
			}
		}

		return $total;
	}


}