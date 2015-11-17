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

		$accounts = Auth::user()->accounts()->join('accounttype','accounttype.id','=','accounts.account_type_id')->where('accounttype.isbudget',false)->get(['accounts.*']);
		$accountoptions = array_combine($accounts->lists('id'), $accounts->lists('accountname'));

		$budgets = Auth::user()->accounts()->join('accounttype','accounttype.id','=','accounts.account_type_id')->where('accounttype.isbudget',true)->get(['accounts.*']);
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
			$account = Accounts::where('id',Input::get('account_id'))->first();
			$store = Store::where('id', Input::get('store_id'))->first();
			$budget = null;
			if(Input::get('counttobudget') === 'true'){
				$budget = Accounts::where('id', Input::get('budget_id'))->first();
			}
			$trans = new Transactions;
			$trans->user()->associate($usr);
			$trans->accounts()->associate($account);
			$trans->transType()->associate($ttype);
			$trans->store()->associate($store);
			$trans->discription = Input::get('discription');
			$trans->amount = doubleval(Input::get('amount'));
			if(Input::get('counttobudget') === 'true'){
				$trans->budget()->associate($budget);
			}
			$trans->date = Input::get('date');

			if($trans->save()) {
				return Redirect::back()->with('message','Transaction created!');
			} else {
				return Redirect::back()->with('error', 'Failed to create transaction!');
			}
		} catch (Exception $e) {
			dd('Failed to create! '.$e->getMessage());
		}
	}

	public function loadPostEditDeleteTransaction($action,$id)
	{
		$id2 = intval($id);
		if($action == 'delete'){
			$trans = Transactions::where('id',$id2)->first();
			return View::make('Modals.deleteTransaction')->with('trans',$trans)->render();
		} else if($action == 'edit') {
			$transtypes = TransType::all();
			$ttoptions = array_combine($transtypes->lists('id'), $transtypes->lists('name'));
		
			$stores = Store::all();
			$storeoptions = array_combine($stores->lists('id'), $stores->lists('name'));

			$accounts = Auth::user()->accounts()->join('accounttype','accounttype.id','=','accounts.account_type_id')->where('accounttype.isbudget',false)->get(['accounts.*']);
			$accountoptions = array_combine($accounts->lists('id'), $accounts->lists('accountname'));

			$budgets = Auth::user()->accounts()->join('accounttype','accounttype.id','=','accounts.account_type_id')->where('accounttype.isbudget',true)->get(['accounts.*']);
			$budgetoptions = array_combine($budgets->lists('id'), $budgets->lists('accountname'));

			$trans = Transactions::where('id',$id2)->first();
		
			return View::make('Modals.edittransaction')->with('accountoptions',$accountoptions)
											  ->with('budgetoptions',$budgetoptions)
											  ->with('ttoptions',$ttoptions)
											  ->with('storeoptions',$storeoptions)
											  ->with('trans',$trans)
											  ->render();
		} else if($action == 'postone') {
			$trans = Transactions::where('id',$id2)->first();
			return View::make('Modals.postonetransaction')->with('trans',$trans)->render();
		}
	}

	public function postEditDeleteTransaction($action, $id)
	{
		$id2 = intval($id);

		if($action == 'delete') {
			$trans = Transactions::find($id2);
			if($trans->delete()){
				return Redirect::back()->with('message','Transaction deleted');
			} else {
				return Redirect::back()->with('error','Transaction was not deleted!');
			}
		} else if ($action == 'edit') {
			if(!is_numeric(Input::get('amount'))) {
				return Redirect::back()->with('error',"The balance must be a number");
			}

			$message = "Updtating: ";
			$trans = Transactions::find($id2);

			if(!$trans->budget_id && Input::get('counttobudget') == 'true'){
				$budget = Accounts::where('id',Input::get('budget_id'))->first();
				$trans->budget()->associate($budget);
				$message .= "Budget, ";
			} else if ($trans->budget_id && $trans->budget_id != intval(Input::get('budget_id'))) {
				$budget = Accounts::where('id',Input::get('budget_id'))->first();
				$trans->budget()->associate($budget);
				$message .= "Budget, ";
			} else if ($trans->budget_id && Input::get('counttobudget') != 'true') {
				$trans->budget()->detach($trans->budget_id);
				$message .= "Budget, ";
			}

			if($trans->trans_type_id != intval(Input::get('transtype_id'))) {
				$transtype = TransType::where('id',Input::get('transtype_id'))->first();
				$trans->transType()->associate($transtype);
				$message .= "Transtype, ";
			}

			if($trans->store_id != intval(Input::get('store_id'))) {
				$store = Store::where('id',Input::get('store_id'))->first();
				$trans->store()->associate($store);
				$message .= "Store, ";
			}

			if($trans->discription != Input::get('discription')){
				$trans->discription = Input::get('discription');
				$message .= "Discription, ";
			}

			if($trans->accounts_id != intval(Input::get('account_id'))) {
				$account = Accounts::where('id',Input::get('account_id'))->first();
				$trans->accounts()->associate($account);
				$message .= "Account, ";
			}

			if($trans->date != Input::get('date')) {
				$trans->date = Input::get('date');
				$message .= "Date, ";
			}

			if($trans->amount != doubleval(Input::get('amount'))) {
				$trans->amount = doubleval(Input::get('amount'));
				$message .= "Amount, ";
			}

			if($trans->save()) {
				return Redirect::back()->with('message','Success '.$message);
			} else {
				return Redirect::back()->with('error', 'Failed '.$message);
			}
		} else if ($action == 'postone') {
			$trans = Transactions::find($id2);
			$account = $trans->accounts;
			$message = "";
			$error = "";
			if($trans->transType->is_credit){
				$account->balance = $account->balance + $trans->amount;
			} else {
				$account->balance = $account->balance - $trans->amount;
			}
			if($account->save()){
				$message .= "Posted to account";
			} else {
				$error .= "Failed to post to account";
			}

			if($trans->budget_id) {
				$budget = $trans->budget;
				if($trans->transType->is_credit){
					$budget->amountagainst = $budget->amountagainst - $trans->amount;
				} else {
					$budget->amountagainst = $budget->amountagainst + $trans->amount;
				}

				if($budget->save()) {
					$message .= " Posted to budget";
				} else {
					$error .= " Failed to post to budget";
				}
			}

			$trans->posted = true;
			$trans->dateposted = date("Y-m-d H:i:s");

			if($trans->save()) {
				$message .= " Trans posted";
			} else {
				$error .= " Failed to po1st";
			}

			if(strlen($error)){
				return Redirect::back()->with('error',$error)->with('message',$message);
			}

			return Redirect::back()->with('message',$message);
		}
	}

	public function loadAddStore()
	{
		return View::make('Modals.addstore')->render();
	}

	public function addStore()
	{
		$store = new Store;
		$store->name = Input::get('storename');
		$store->description = Input::get('storedescription');

		if ($store->save()) {
			return Redirect::back()->with('message', 'Store was created!');
		} else {
			return Redirect::back()->with('error', 'Failed to create store!');
		}
	}

	public function loadAddTransType()
	{
		return View::make('Modals.addtranstype')->render();
	}

	public function addTransType()
	{
		$transtype = new TransType;
		$transtype->name = Input::get('transtype');
		$transtype->is_credit = (Input::get('iscredit') == 'true' ? true:false);

		if ($transtype->save()) {
			return Redirect::back()->with('message', 'TransType was created!');
		} else {
			return Redirect::back()->with('error', 'Failed to create transtype!');
		}
	}
}