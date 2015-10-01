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
		if(Auth::attempt(Input::only('username','password'),true)){
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
});