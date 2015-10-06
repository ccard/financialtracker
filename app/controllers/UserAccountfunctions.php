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

		$user = User::where('id',Auth::user()->id)->first();
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
		$stores = Store::all();
		$storeoptions = array_combine($stores->lists('id'), $stores->lists('name'));
		return View::make('Modals.addaccount')->with('actypeoptions',$actypeoptions)->with('storeoptions',$storeoptions)->render();
	}

	public function addAccount()
	{
		if(!is_numeric(Input::get('balance'))){
			return Redirect::back()->with('error',"The balance must be a number you idiot!");
		}

		try {
			$usr = User::where('id',Auth::user()->id)->first();
			$actype = AccountType::find(intval(Input::get('accounttype_id')));
			$account = new Accounts;
			$account->accountType()->associate($actype);
			$account->user()->associate($usr);
			$store = Store::where('id',intval(Input::get('store_id')))->first();
			$account->store()->associate($store);
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

	public function loadEditDeleteAccount($action,$id)
	{
		$id2 = intval($id);
		if($action == 'delete'){
			$account = Accounts::where('id',$id2)->first();
			return View::make('Modals.deleteaccount')->with('account',$account)->render();
		} else if ($action == "edit"){
			$actypes = AccountType::all();
			$actypeoptions = array_combine($actypes->lists('id'), $actypes->lists('name'));
			$account = Accounts::where('id',$id2)->first();
			$stores = Store::all();
			$storeoptions = array_combine($stores->lists('id'), $stores->lists('name'));
			return View::make('Modals.editaccount')->with('account',$account)->with('actypeoptions',$actypeoptions)->with('storeoptions',$storeoptions)->render();
		}

		return Redirect::back()->with('error','Nothing was done!');
	}

	public function editDeleteAccount($action,$id)
	{
		$id2 = intval($id);
		if($action == 'delete'){
			if (Input::get('delete') == 'delete') {
				$account = Accounts::where('id',$id2)->first();
				$message = '';
				$error = '';
				if($account->transactions()->delete()){
					$message .= 'All associated transactions deleted!  ';
				} else {
					$error .= "Failed to delete transactions! ";
				}
				if($account->delete()){
					$message .= 'The account was deleted!';
				} else {
					$error .= "Failed to delete the account!!!";
				}

				return Redirect::back()->with('message',$message)->with('error',$error);
			} else if(Input::get('delete') == 'deactivate'){
				$account = Accounts::where('id',$id2)->first();
				$account->active = false;
				if($account->save()){
					return Redirect::back()->with('message','Account was deacativated!');
				} else {
					return Redirect::back()->with('error','Failed to deactivate account!!');
				}
			}
		} else if ($action == 'edit'){
			$account = Accounts::where('id',$id2)->first();

			$message = '';

			if(!is_numeric(Input::get('balance'))){
				return Redirect::back()->with('error', 'The balance must be a number!');
			}

			if($account->accountType->id != Input::get('accounttype_id')){
				$actype = AccountType::find(intval(Input::get('accounttype_id')));
				$account->accountType()->associate($actype);
				$message .= "Updating account type. ";
			}
			if($account->store->id != Input::get('store_id')) {
				$store = Store::where('id',intval(Input::get('store_id')))->first();
				$account->store()->associate($store);
				$message .= "Updating institution. ";
			}
			if($account->discription != Input::get('discription')){
				$account->discription = Input::get('discription');
				$message .= "Updating discription. ";
			}
			if($account->accountname != Input::get('accountname')){
				$account->accountname = Input::get('accountname');
				$message .= "Updating accountname. ";
			}
			if($account->balance != doubleval(Input::get('balance'))){
				$balance = doubleval(Input::get('balance'));
				$store = $account->store;
				$trans = new Transactions;
				$trans->store()->associate($store);
				$trans->date = date("Y-m-d H:i:s");
				$trans->amount = abs($account->balance-$balance);
				$trans->posted = true;
				$trans->dateposted = date("Y-m-d H:i:s");
				$trans->accounts()->associate($account);
				$user = User::where('id',Auth::user()->id)->first();
				$trans->user()->associate($user);
				if($account->balance < $balance){
					$type = TransType::where('name','Deposite')->first();
					$trans->transType()->associate($type);
				} else {
					$type = TransType::where('name','Withdrawl')->first();
					$trans->transType()->associate($type);
				}
				if($trans->save()){
					$message .= "Transfer recored complete. ";
					$account->balance = $balance;
					$message .= "Updating balance. ";
				} else {
					$message .= "Failed to create trans action for update!  ";
				}
			}
			if($account->active && Input::get('active') == 'notactive'){
				$account->active = false;
				$message .= "Deactivating account. ";
			} else if (!$account->active && Input::get('active') == 'active'){
				$account->active = true;
				$message .= "Acctivating account. ";
			}

			if(!empty($message)){
				if($account->save()){
					$message .= "The updates where saved!";
					return Redirect::back()->with('message',$message);
				} else {
					$message .= "Failed to update!";
					return Redirect::back()->with('error',$message);
				}
			} else {
				return Redirect::back()->with('message','No changes made!');
			}
		}
	}
}