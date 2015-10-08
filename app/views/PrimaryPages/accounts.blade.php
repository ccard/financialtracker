@extends('master')
@section('script')
$('.modal_account_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	
	if(this_id == '-1'){
	console.log("{{{ $_SERVER['REQUEST_URI']}}}"+'/'+this_action);
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/'+this_action, function(data){
			$('#modalwindow').modal();
			$('#modalwindow').on('shown.bs.modal', function(){
				$('#modalwindow .load_modal').html(data);
			});
			$('#modalwindow').on('hidden.bs.modal',function(){
				$('#modalwindow .load_modal').html('');
			});
		});
	} else {
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/'+this_action+'/'+this_id, function(data){
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
$('.currency').blur(function(){
	$('.currency').formatCurrency();
});
@stop
@section('navbaritems')
	@if(Auth::check())
	<button class="btn btn-primary btn-link navbar-btn modal_account_btn" data-toggle="modal" data-id="-1" data-action="addaccounttype"><b class="glyphicon glyphicon-plus"></b>Add account type</button>
	@endif
@stop
@section('content')
@if(Auth::check())
<div class="panel panel-default" style="padding-left: 5px;float: left; margin: 15px; min-width: 100px; min-height: 100px">
	<div class="panel-header">
	<h2 style="float: left">Accounts</h2>
	@if($hasaccounttypes)
		<button id="addaccount" class="btn btn-primary btn-link pull-right modal_account_btn" data-toggle="modal" data-id="-1" data-action="addaccount"><b class="glyphicon glyphicon-plus"></b>Add account</button>
	@endif
	</div>
	<hr style="clear: both"/>
	<div class="panel-body">
			@if($hasaccounttypes)
			<table class="table table-hover ">
				<thead>
					<tr>
						<th>Type</th>
						<th>Institution</th>
						<th>Account name</th>
						<th>Description</th>
						<th>Balance</th>
						<th>Active</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
					@foreach($user->accounts as $account)
						@if(!$account->accounttype->isbudget)
						<tr>
							<td>{{{$account->accounttype->name}}}</td>
							<td>{{{$account->store->name}}}</td>
							<td>{{{$account->accountname}}}</td>
							<td>{{{$account->discription}}}</td>
							<td><b class="glyphicon glyphicon-usd"></b>{{{$account->balance}}}</td>
							<td> 
							@if($account->active)
							<b class="glyphicon glyphicon-ok" style="color:green"></b> 
							@else 
							<b class="glyphicon glyphicon-remove" style="color:red"></b></td>
							@endif
							<td><button class="btn-link modal_account_btn" data-toggle="modal" data-id="{{{$account->id}}}" data-action="edit"><b class="glyphicon glyphicon-pencil"></b></button><button class="btn-link btn-danger modal_account_btn" data-toggle="modal" data-id="{{{$account->id}}}" data-action="delete"><b class="glyphicon glyphicon-trash" style="color:red"></b></button></td>
						</tr>
						@endif
					@endforeach			
				</tbody>
			</table>
			@else
				<p>Please add an account type</p>
			@endif
		@if(!$user->accounts->count())
		<p>I See you don't have any accounts please click on the manage accounts button <b class="glyphicon glyphicon-arrow-up"> </b>.</p>
		@endif
	</div>
</div>
<div class="panel panel-default" style="padding-left: 5px;float: left; margin: 15px; min-width: 100px; min-height: 100px">
	<div class="panel-header">
	<h2 style="float: left">Budgets</h2>
	@if($hasaccounttypes)
		<button id="addaccount" class="btn btn-primary btn-link pull-right modal_account_btn" data-toggle="modal" data-id="-1" data-action="addbudget"><b class="glyphicon glyphicon-plus"></b>Add budget</button>
	@endif
	</div>
	<hr style="clear: both"/>
	<div class="panel-body">
			@if($hasaccounttypes)
			<table class="table table-hover ">
				<thead>
					<tr>
						<th>Type</th>
						<th>Budget name</th>
						<th>Description</th>
						<th>Limit</th>
						<th>Amount against</th>
						<th>Active</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
					@foreach($user->accounts as $account)
						@if($account->accounttype->isbudget)
						<tr>
							<td>{{{$account->accounttype->name}}}</td>
							<td>{{{$account->accountname}}}</td>
							<td>{{{$account->discription}}}</td>
							<td><b class="glyphicon glyphicon-usd"></b>{{{$account->balance}}}</td>
							<td style="color:red">-<b class="glyphicon glyphicon-usd"></b>{{{$account->amountagainst}}}</td>
							<td> 
							@if($account->active)
							<b class="glyphicon glyphicon-ok" style="color:green"></b> 
							@else 
							<b class="glyphicon glyphicon-remove" style="color:red"></b></td>
							@endif
							<td><button class="btn-link modal_account_btn" data-toggle="modal" data-id="{{{$account->id}}}" data-action="edit"><b class="glyphicon glyphicon-pencil"></b></button><button class="btn-link btn-danger modal_account_btn" data-toggle="modal" data-id="{{{$account->id}}}" data-action="delete"><b class="glyphicon glyphicon-trash" style="color:red"></b></button></td>
						</tr>
						@endif
					@endforeach			
				</tbody>
			</table>
			@else
				<p>Please add an account type</p>
			@endif
		@if(!$user->accounts->count())
		<p>I See you don't have any accounts please click on the manage accounts button <b class="glyphicon glyphicon-arrow-up"> </b>.</p>
		@endif
	</div>
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