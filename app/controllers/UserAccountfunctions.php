<?php
class UserAccountfunctions extends BaseController {
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
		$accounttypes = AccountType::all();
		$hasaccounttypes = count($accounttypes);

		$user = Auth::user();
		return View::make('PrimaryPages.accounts')->with('hasaccounttypes',$hasaccounttypes)->with('user',$user);
	}

	public function loadAddAccountType()
	{
		return View::make('Modals.addaccounttype')->render();
	}

	public function addAccountType()
	{
		dd('ACccount type');
	}
}