@extends('master')
@section('script')
$('.modal_trans_btn').on('click',function(){
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
	<button class="btn btn-primary btn-link navbar-btn modal_trans_btn" data-toggle="modal" data-id="-1" data-action="addtranstype"><b class="glyphicon glyphicon-plus"></b>Add trans type</button>
	<button class="btn btn-primary btn-link navbar-btn modal_trans_btn" data-toggle="modal" data-id="-1" data-action="addstore"><b class="glyphicon glyphicon-plus"></b>Add store</button>
	@endif
@stop
@section('content')
@if(Auth::check())
<div class="panel panel-default" style="padding-left: 5px; margin: 15px; min-width: 100px; min-height: 100px">
	<div class="panel-header">
	<h2 style="float: left">Transactions</h2>
	@if($hastranstypes)
		<button id="addtrans" class="btn btn-primary btn-link pull-right modal_trans_btn" data-toggle="modal" data-id="-1" data-action="addtransaction"><b class="glyphicon glyphicon-plus"></b>Add transaction</button>
	@endif
	</div>
	<hr style="clear: both"/>
	<div class="panel-body">
			@if($hasaccounttypes)
			<table class="table table-hover ">
				<thead>
					<tr>
						<th>Date</th>
						<th>Type</th>
						<th>Store</th>
						<th>Discription
						<th>Account</th>
						<th>Ammount</th>
						<th>Posted</th>
						<th>Date Posted</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
					@foreach($user->transactions as $trans)
						<tr>
							<td>{{{$trans->transtype->name}}}</td>
							<td>{{{$trans->store->name}}}</td>
							<td>{{{$trans->date}}}</td>
							<td>{{{$trans->accounts->name}}}</td>
							<td>{{{$at->discription}}}</td>
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