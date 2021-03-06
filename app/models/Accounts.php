<?php

/**
* 
*/
class Accounts extends Eloquent
{
	protected $fillable = array('user_id','account_type_id','store_id','balance','active','discription','accountname','amountagainst');
	public $timestamps = false;
	protected $table = "accounts";

	public function user(){
		return $this->belongsTo('User');
	}

	public function accountType(){
		return $this->belongsTo('AccountType');
	}

	public function transactions(){
		return $this->hasMany('Transactions');
	}

	public function store()
	{
		return $this->belongsTo('Store');
	}
}
?>