<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('users')->truncate();

		$users = array(
			['1', 'Yurii', '12345', '1', '1', '0', '0'],
			['2', 'Alex', '12345', '1', '1', '0', '0'],
			['3', 'Andrey', '12345', '1', '1', '0', '0'],
			['4', 'Igor', '12345', '1', '1', '0', '0']
		);

		// Uncomment the below to run the seeder
		DB::table('users')->insert($users);
	}

}
