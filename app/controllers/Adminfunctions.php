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
	public function loadEditDeleteUser($action,$id){
		$id2 = intval($id);
		if($action === "edit"){
			$user = User::where('id',$id2)->first();
			$privilages = Privilages::all();
			$privilagesoptions = array_combine($privilages->lists('id'), $privilages->lists('name'));
			return View::make('Modals.editusermodal')->with('user',$user)->with('privilages',$privilagesoptions)->render();
		} else if($action === 'delete') {
			$user = User::where('id',$id2)->first();
			return View::make('Modals.deleteusermodal')->with('user',$user)->render();
		}
	}
	public function editDeleteUser($action,$id){
		$id2 = intval($id);
		if($action === "edit"){
			$user = User::where('id',$id2)->first();
			$changed = false;
			if(!empty(Input::get('password')))
			{
				$changed = true;
				if(Input::get('password') !== Input::get('confpassword')){
					return Redirect::back()->with('error','The Passwords dont match!');
				} else {
					$user->password = Hash::make(Input::get('password'));
				}
			}
			if($user->username !== Input::get('username')){
				$changed = true;
				$user->username = Input::get('username');
			}
			if($user->firstname !== Input::get('firstname')){
				$changed = true;
				$user->firstname = Input::get('firstname');
			}
			if($user->lastname !== Input::get('lastname')){
				$changed = true;
				$user->lastname = Input::get('lastname');
			}
			if($user->privilage->id !== intval(Input::get('privilage_id'))){
				$changed = true;
				$privlage = Privilages::find(intval(Input::get('privilage_id')));
				$user->privilage()->associate($privilage); 
			}

			if($changed){
				if($user->save()){
					return Redirect::back()->with('message','User '.$user->username.' updated');
				} else {
					return Redirect::back()->with('error','Failed to update '.$user-$username.'!!');
				}
			} else {
				return Redirect::back()->with('message','No changes made!');
			}
			
		} else if($action === 'delete') {
			$user = User::where('id',$id2)->first();
			$message = "";
			$errors = "";
			if($user->accounts()->delete()){
				$message .= "Deleted all associated accounts!  ";
			} else {
				$errors .= "Failed to delete accounts!!  ";
			}
			if($user->transactions()->delete()){
				$message .= "Deleted all related transactions!  ";
			} else {
				$errors .= "Failed to delete transactions!!  ";
			}
			if($user->delete()){
				$message .= "Deleted the user!";
			} else {
				$errors .= "Failed to delete the user!";
			}

			if(!empty($errors)){
				return Redirect::back()->with('message',$message)->with('error',$errors);
			}
			return Redirect::back()->with('message',$message); 
		}
	}
	public function loadAddPriv(){
		return View::make('Modals.addprivmodal')->render();
	}
	public function addPriv(){
		$privilages = Privilages::where('name',"'".Input::get('privilage')."'")->get();
		if(count($privilages)){
			return Redirect::back()->with('error','Privilage already exists');
		}
		try{
			$priv = new Privilages;
			$priv->name = Input::get('privilage');
			if($priv->save()){
				return Redirect::back()->with('message','The privilage was added!');
			} else {
				return Redirect::back()->with('error','The privilage was not saved!');
			}
		} catch (Exception $e){
			$this->command->error('Error: '.$e->getMessage());
		}
	}
}