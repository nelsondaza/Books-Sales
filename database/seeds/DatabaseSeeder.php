<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// $this->call(UsersTableSeeder::class);

		DB::statement('SET FOREIGN_KEY_CHECKS=0;');

		\App\Models\Sales::truncate();
		\App\Models\Books::truncate();

		factory(\App\Models\Books::class, 50)->create();
		factory(\App\Models\Sales::class, 200)->create();

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

	}
}
