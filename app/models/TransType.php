<?php

/**
* 
*/
class TransType extends Eloquent
{
	protected $fillable = array('name','is_credit');
	public $timestamps=false;
	protected $table = "transtype";

	public function transactions(){
		return $this->hasMany('Transactions');
	}
	
}

?>