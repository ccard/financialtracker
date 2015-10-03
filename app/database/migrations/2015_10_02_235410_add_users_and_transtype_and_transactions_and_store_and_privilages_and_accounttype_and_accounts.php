<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersAndTranstypeAndTransactionsAndStoreAndPrivilagesAndAccounttypeAndAccounts extends Migration {

	public function up()
	{
		Schema::create('privilages',function($table){
			$table->increments('id');
			$table->string('name')->unique();
		});
		Schema::create('users',function($table){
			$table->increments('id');
			$table->string('password',60)->nullable();
			$table->string('username')->unique();
			$table->string('firstname');
			$table->string('lastname');
			$table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('privilage_id');
			$table->string('remember_token')->nullable();
		});
		Schema::create('accounttype',function($table){
			$table->increments('id');
			$table->string('name');
			$table->boolean('isbudget')->default(false);
		});
		Schema::create('accounts',function($table){
			$table->increments('id');
			$table->integer('user_id');
			$table->index('user_id');
			$table->integer('account_type_id');
			$table->string('institution');
			$table->double('balance',20,2)->default(0.0);
			$table->boolean('active')->default(true);
			$table->string('discription');
			$table->string('accountname');
			$table->double('amountagainst',20,2)->default(0.0);
		});
		Schema::create('stores',function($table){
			$table->increments('id');
			$table->string('name');
			$table->string('description');
		});
		Schema::create('transtype',function($table){
			$table->increments('id');
			$table->string('name');
			$table->boolean('is_credit')->default(false);
		});
		Schema::create('transactions',function($table){
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->index('user_id');
			$table->integer('trans_type_id');
			$table->integer('store_id');
			$table->dateTime('date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('accounts_id');
			$table->index('accounts_id');
			$table->double('amount',20,2);
			$table->boolean('posted')->default(false);
			$table->dateTime('dateposted')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
		Schema::drop('accounts');
		Schema::drop('accounttype');
		Schema::drop('privilages');
		Schema::drop('stores');
		Schema::drop('transactions');
		Schema::drop('transtype');
	}

}
