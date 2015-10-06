<?php

/**
* 
*/
class Store extends Eloquent
{
	protected $fillable = array('name','description');
	public $timestamps=false;
	protected $table="stores";

	public function transactions(){
		return $this->hasMany('Transactions');
	}

	public function accounts(){
		return $this->hasMany('Accounts');
	}
}
?>