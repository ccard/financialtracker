@extends('master')
@section('script')
$('.modal_trans_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	if(this_action == 'add'){
	console.log("{{{ $_SERVER['REQUEST_URI']}}}"+'/transactions/'+this_action+'/modal');
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/transactions/'+this_action, function(data){
			$('#modalwindow').modal();
			$('#modalwindow').on('shown.bs.modal', function(){
				$('#modalwindow .load_modal').html(data);
			});
			$('#modalwindow').on('hidden.bs.modal',function(){
				$('#modalwindow .load_modal').html('');
			});
		});
	}
});
$('.modal_account_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	console.log('here');
	if(this_action == 'add'){
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/user/account/'+this_action, function(data){
			$('#modalwindow').modal();
			$('#modalwindow').on('shown.bs.modal', function(){
				$('#modalwindow .load_modal').html(data);
			});
			$('#modalwindow').on('hidden.bs.modal',function(){
				$('#modalwindow .load_modal').html('');
			});
		});
	}
});
@stop
@section('navbaritems')
	@if(Auth::check())
	@if($user->accounts->count())
	<button class="btn btn-primary btn-link navbar-btn modal_trans_btn" data-toggle="modal" data-id="" data-action="add"><b class="glyphicon glyphicon-plus"></b>Add transaction</button>
	@endif
	@endif
@stop
@section('content')
@if(Auth::check())
<div class="panel panel-default" style="padding-left: 5px;float: left; margin-right: 15px; min-width: 100px; min-height: 100px">
	<div class="panel-header">
	<h2 style="float: left">Accounts Summery</h2> <h4 style="float:right"><a href="{{{ url('home/accounts')}}}" class="btn btn-primary btn-link">Manage Accounts</a></h4>
	</div>
	<hr style="clear: both"/>
	<div class="panel-body">
		@if($user->accounts->count())
		yah
		@else
		<p>I See you don't have any accounts please click on the manage accounts button <b class="glyphicon glyphicon-arrow-up"> </b>.</p>
		@endif
	</div>
</div>
<div class="panel panel-default" style="padding-left:5px; float: left; margin-right: 15px; min-width:100px; min-height: 100px">
<div class="panel-header">
	<h2 style="float: left">Transaction Summery</h2> @if($user->accounts->count())<h4 style="float:right"><a href="{{{ url('home/transactions')}}}" class="btn btn-primary btn-link">Manage Transactions</a></h4>@endif
	</div>
	<hr style="clear: both"/>
	<div class="panel-body">
	@if($user->transactions->count())
	yaht
	@elseif($user->accounts->count())
	<p>I See you don't have any transactions please click on the manage transactions button <b class="glyphicon glyphicon-arrow-up"> </b>.</p>
	@endif
</div>
@endif
@stop
@section('nonauthcontent')
<div style="margin: 0 auto; width: 60%">
	<div class="box" style="float: left">
		<iframe src="http://www.engadget.com" width="500px" height="500px"></iframe>
	</div>
	<div class="box" style="float: left; margin-left: 20px">
		<iframe src="http://www.cad-comic.com/cad/" width="500px" height="500px"></iframe>
	</div>
</div>
@stop