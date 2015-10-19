<?php
class Transactionfunctions extends BaseController {
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

	public function loadPage() {
		$hastranstypes = TransType::count();
		$user = Auth::user();
		return View::make('PrimaryPages.transactions')->with('hastranstypes',$hastranstypes)->with('user',$user);
	}

	public function loadAddTrans(){

		$transtypes = TransType::all();
		$ttoptions = array_combine($transtypes->lists('id'), $transtypes->lists('name'));
		
		$stores = Store::all();
		$storeoptions = array_combine($stores->lists('id'), $stores->lists('name'));

		$accounts = Auth::user()->accounts()->join('accounttype','accounttype.id','=','accounts.account_type_id')->where('accounttype.isbudget',false)->get();
		$accountoptions = array_combine($accounts->lists('id'), $accounts->lists('accountname'));

		$budgets = Auth::user()->accounts()->join('accounttype','accounttype.id','=','accounts.account_type_id')->where('accounttype.isbudget',true)->get();
		$budgetoptions = array_combine($budgets->lists('id'), $budgets->lists('accountname'));
		
		return View::make('Modals.addtransaction')->with('accountoptions',$accountoptions)
											  ->with('budgetoptions',$budgetoptions)
											  ->with('ttoptions',$ttoptions)
											  ->with('storeoptions',$storeoptions)->render();
	}

	public function addTransaction()
	{
		if(!is_numeric(Input::get('amount'))) {
			return Redirect::back()->with('error',"The balance must be a number");
		}

		try{
			$usr = Auth::user();
			$ttype = TransType::where('id',Input::get('transtype_id'))->first();
			$account = Accounts::where('id',Input::get('acount_id'))->first();
			$store = Store::where('id', Input::get('store_id'))->first();
			$budget = null;
			if(Input::get('counttobudget') === 'true'){
				$budget = Accounts::where('id', Input::get('budget_id'))->first();
			}
			$trans = new Transactions;
			$trans->user()->associate($user);
			$trans->accounts()->associate($account);
			$trans->transType()->associate($ttype);
			$trans->store()->associate($store);
			$trans->discription = Input::get('discription');
			$trans->amount = doubleval(Input::get('amount'));
		} catch (Exception $e) {
			dd('Failed to create! '.$e->getMessage());
		}
	}

}