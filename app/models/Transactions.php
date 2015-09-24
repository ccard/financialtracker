<?php
	
	/**
	* 
	*/
	class Transactions extends Eloquent
	{
		
		protected $fillable = array('user_id','trans_type_id','store_id','date','accounts_id','amount');
		public $timestamps = false;
		protected $table = "transactions";

		public function user(){
			return $this->belongsTo('User');
		}

		public function transType(){
			return $this->belongsTo('TransType');
		}

		public function store(){
			return $this->belongsTo('Store');
		}

		public function accounts(){
			return $this->belongsTo('Accounts');
		}
	}
?>