<?php
class AccountInfo extends BaseController {
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

	public function loadPage()
	{
		return View::make('PrimaryPages.accountinfo')->with('user', Auth::user());
	}

	public function loadEdit($action)
	{
		if ($action === "editpassword") {	
			return View::make('Modals.edituserpassword')->render();
		} else if ($action === "edituname") {
			return View::make('Modals.editusername')->with('username', Auth::user()->username)->render();
		} else if ($action === "editname") {
			return View::make('Modals.edituserfullname')->with('firstname', Auth::user()->firstname)->with('lastname', Auth::user()->lastname)->render();
		}
	}

	public function editPassword()
	{
		$old_pass = Input::get('password');
		$new_pass = Input::get('newpassword');
		$confirm = Input::get('confirmpassword');

		$user = Auth::user();

		if (Hash::check($old_pass, $user->password)) {
			if ($new_pass != $confirm) {
				return Redirect::back()->with('error', 'Your new password was not confirmed');
			}

			$user->password = Hash::make($new_pass);

			if ($user->save())
			{
				return Redirect::back()->with('message', 'Your password has been updated');
			} else {
				return Redirect::back()->with('error', 'Your password has not been updated');
			}
		} else {
			return Redirect::back()->with('error', 'Failed to varerify password');
		}
	}

	public function editusername()
	{
		$user = Auth::user();
		$newUsername = Input::get('username');

		if ($user->username != $newUsername) {
			$user->username = $newUsername;
			$user->save();
			return Redirect::back()->with('message', 'Your username has been updated');
		} else {
			return Redirect::back()->with('error', 'No change detected');
		}
	}

	public function edituserfullname()
	{
		$user = Auth::user();
		$newfirst = Input::get('firstname');
		$newlast = Input::get('lastname');

		if ($newfirst != $user->firstname || $newlast != $user->lastname) {
			$user->firstname = ($newfirst != $user->firstname ? $newfirst : $user->firstname);
			$user->lastname = ($newlast != $user->lastname ? $newlast : $user->lastname);

			$user->save();
			return Redirect::back()->with('message', 'Your name has been updated');
		} else {
			return Redirect::back()->with('error', 'No change detected');
		}
	}

}