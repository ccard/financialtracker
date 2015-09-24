<?php

/**
* 
*/
class AccountType extends Eloquent
{
	protected $fillable = array('name');
	public $timestamps=false;
	protected $table="accounttype";

	public function accounts(){
		return $this->hasMany('Accounts');
	}

}

?>