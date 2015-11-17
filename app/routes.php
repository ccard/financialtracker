<?php
use Illuminate\Support\MessageBag;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return Redirect::to('home');
});

Route::get('home', function(){
	//dd('test');
	if(Auth::check() && Auth::user()->isAdmin()){
		$users = User::where('privilage_id','!=',Auth::user()->privilage_id)->get();
		$privs = Privilages::all();
		return View::make('PrimaryPages.adminhome')->with('users',$users)->with('privs',$privs);
	} else if (Auth::check()) {
		$user= Auth::user();
		return View::make('PrimaryPages.home')->with('user',$user);	
	}
	return View::make('PrimaryPages.home')->with('user',array("none"=>"none"));
});

Route::post('home', function(){
	if(Auth::check()){
		return Redirect::to('home');
	} else {
		if(Auth::attempt(Input::only('username','password'),(Input::get('remember') === 'true'?true:false))){
			return Redirect::intended('home')->with('message',"Logged in!");
		} else {
			return Redirect::to('home')->with('error',"Invalid Credentials!");
		}
	}
});

Route::get('logout', function(){
	Auth::logout();
	return Redirect::to('home')->with('message',"You are logged out!");
});

Route::group(array('before'=>'auth'), function(){

	Route::get('home/admin/user/add','Adminfunctions@loadAddUser');

	Route::post('home/admin/user/add','Adminfunctions@addUser');

	Route::get('home/admin/privilage/add','Adminfunctions@loadAddPriv');

	Route::post('home/admin/privilage/add','Adminfunctions@addPriv');

	Route::get('home/admin/user/{action}/{id}','Adminfunctions@loadEditDeleteUser');

	Route::post('home/admin/user/{action}/{id}','Adminfunctions@editDeleteUser');

	Route::get('home/user/settings',function(){

	});

	Route::get('home/accounts','UserAccountfunctions@loadPage');

	Route::get('home/accounts/addaccounttype','UserAccountfunctions@loadAddAccountType');

	Route::post('home/accounts/addaccounttype','UserAccountfunctions@addAccountType');

	Route::get('home/accounts/addaccount','UserAccountfunctions@loadAddAccount');

	Route::get('home/accounts/addbudget','UserAccountfunctions@loadAddBudget');

	Route::post('home/accounts/addaccount','UserAccountfunctions@addAccount');

	Route::get('home/accounts/{action}/{id}','UserAccountfunctions@loadEditDeleteAccount');

	Route::post('home/accounts/{action}/{id}','UserAccountfunctions@editDeleteAccount');

	Route::get('home/transactions','Transactionfunctions@loadPage');

	Route::get('home/transactions/addtransaction','Transactionfunctions@loadAddTrans');
	Route::post('home/transactions/addtransaction','Transactionfunctions@addTransaction');

	Route::get('home/transactions/{action}/{id}','Transactionfunctions@loadPostEditDeleteTransaction');
	Route::post('home/transactions/{action}/{id}','Transactionfunctions@postEditDeleteTransaction');

	Route::get('home/transactions/addstore','Transactionfunctions@loadAddStore');
	Route::post('home/transactions/addstore','Transactionfunctions@addStore');

	Route::get('home/transactions/addtranstype','Transactionfunctions@loadAddTransType');
	Route::post('home/transactions/addtranstype','Transactionfunctions@addTransType');

});