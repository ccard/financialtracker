<?php

class UserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run()
	{
		DB::table('users')->delete();
		DB::table('privilages')->delete();

		try{
		$privilage = new Privilages;
		$privilage->name = 'Admin';
		$privilage->save();
		$user = new User;
		$user->username = 'admin@admin.com';
		$user->firstname = 'Chris';
		$user->lastname = 'Card';
		$user->privilage()->associate($privilage);
		if($user->save())
		{
			$this->command->info('User Success');
		}
		} catch(Exception $e){
			$this->command->error('Error: '.$e->getMessage());
		}
	}

}