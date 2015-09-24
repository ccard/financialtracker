<?php

	class Privilages extends Eloquent
	{
		protected $fillable = array('name');

		public $timestamps=false;
		protected $table="privilages";

		public function user(){
			return $this->hasMany('User');
		}

	}
?>