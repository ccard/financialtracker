<?php

class Adminfunctions extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function loadAddUser()
	{
		$privilages = Privilages::all();
		$privilagesoptions = array_combine($privilages->lists('id'), $privilages->lists('name'));
		return View::make('Modals.addusermodal')->with('privilages',$privilagesoptions)->render();
	}

	public function addUser(){
		$firstname = Input::get('firstname');
		$lastname = Input::get('lastname');
		$username = Input::get('username');
		$privilage_id = Input::get('privilage_id');
		$password = Input::get('password');
		$confpass = Input::get('confpassword');

		if($password !== $confpass){
			return Redirect::back()->with('error','Passwords did not match');
		}

		$privilage = Privilages::find($privilage_id);
		if(empty($privilage)){
			return Redirect::back()->with('error','The privialge does not exist');
		}

		try{
		$user = new User;
		$user->firstname = $firstname;
		$user->lastname = $lastname;
		$user->username = $username;
		$user->password = Hash::make($password);
		$user->privilage()->associate($privilage);
		if($user->save()){
			return Redirect::back()->with('message','The user was added!');
		} else {
			return Redirect::back()->with('error','Failed to add user');
		}
	}catch(Exception $e){
		$this->command->error('Error: '.$e->getMessage());
	}
	}

}