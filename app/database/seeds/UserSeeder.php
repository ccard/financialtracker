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
		DB::table('transtype')->delete();
		DB::table('stores')->delete();

		try{
		$transtype1 = new TransType;
		$transtype1->name = "Withdrawl";
		$transtype1->is_credit = false;
		if($transtype1->save()){
			$this->command->info('User Success trans type 1');
		}
		$transtype2 = new TransType;
		$transtype2->name = "Deposite";
		$transtype2->is_credit = true;
		if($transtype2->save()){
			$this->command->info('User Success trans type 2');
		}
		$store = new Store;
		$store->name = "U.S. Bank";
		$store->description = "U.S. Bank banker";
		if($store->save()){
			$this->command->info('User Success store');
		}
		$privilage = new Privilages;
		$privilage->name = 'Admin';
		$privilage->save();
		$user = new User;
		$user->username = 'admin@admin.com';
		$user->firstname = 'Chris';
		$user->lastname = 'Card';
		$user->privilage()->associate($privilage);
		$user->password = Hash::make('password'); //If you think this wont change your wrong;
		if($user->save())
		{
			$this->command->info('User Success');
			if($user->isAdmin()){
				$this->command->info('User Success admin');
			}
		}
		} catch(Exception $e){
			$this->command->error('Error: '.$e->getMessage());
		}
	}

}