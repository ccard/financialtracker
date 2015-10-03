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
		if(empty(AccountType::where('name',Input::get('accounttype'))->first())){
			$at = new AccountType;
			$at->name = Input::get('accounttype');
			$at->isbudget = (Input::get('isbudget')==='true'?true:false);
			if($at->save()){
				return Redirect::back()->with('message','New account type saved!');
			}
		} else {
			return Redirect::back()->with('error','Account type already exists');
		}
	}

	public function loadAddAccount()
	{
		$actypes = AccountType::all();
		$actypeoptions = array_combine($actypes->lists('id'), $actypes->lists('name'));
		return View::make('Modals.addaccount')->with('actypeoptions',$actypeoptions)->render();
	}

	public function addAccount()
	{
		if(!is_numeric(Input::get('balance'))){
			return Redirect::back()->with('error',"The balance must be a number you idiot!");
		}

		try {
			$user = Auth::user();
				$actype = AccountType::find(intval(Input::get('accounttype_id')));
				$account = new Accounts;
				$account->accountType()->associate($actype);
				$account->user()->associate($user);
				$account->institution = Input::get('institution');
				$account->balance = doubleval(Input::get('balance'));
				$account->discription = Input::get('discription');
				$account->accountname = Input::get('accountname');
				$account->active = true;
				$account->amountagainst = 0.0;
				if($account->save()){
					return Redirect::back()->with('message','Your new account is created');
				} else {
					return Redirect::back()->with('error','Failed to create your new account!!');
				}
		} catch (Exception $e) {
			dd('Failed to create! '.$e->getMessage());
		}
	}
}