<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersAndTranstypeAndTransactionsAndStoreAndPrivilagesAndAccounttypeAndAccounts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
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
			$table->foreign('privilage_id')->references('id')->on('privilages');
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
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->index('user_id');
			$table->integer('account_type_id')->nullable();
			$table->foreign('account_type_id')->references('id')->on('accounttype')->onDelete('null');
			$table->string('institution');
			$table->double('balance',20,2)->default(0.0);
			$table->boolean('active')->default(true);
			$table->string('description');
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
			$table->boolean('is_credit')->default('false');
		});
		Schema::create('transactions',function($table){
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->index('user_id');
			$table->integer('trans_type_id')->nullable();
			$table->foreign('trans_type_id')->references('id')->on('transtype')->onDelete('null');
			$table->integer('store_id')->nullable();
			$table->foreign('store_id')->references('id')->on('stores')->onDelete('null');
			$table->dateTime('date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('accounts_id');
			$table->foreign('accounts_id')->references('id')->on('accounts')->onDelete('cascade');
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
