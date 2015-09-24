<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $primaryKey='username';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $fillable = array('username','firstname','lastname','created_at','updated_at','privilage_id');

	public function getAuthIdentifier(){
		return $this->getKey();
	}

	public function getAuthPassword(){
		return $this->password;
	}

	public function isAdmin(){
		if($this->privilage()->name == 'Admin'){
			return true;
		}
		return false;
	}

	public function privilage(){
		return $this->belongsTo('Privilages');
	}

	public function transactions(){
		return $this->hasMany('Transactions');
	}

	public function accounts(){
		return $this->hasMany('Accounts');
	}

}
