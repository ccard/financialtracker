@extends('master')
@section('addheaddata')
@if(Auth::check())
<script type="text/javascript" src="{{ url('http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js') }}"></script>
<script src="{{ url('http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
@endif
@stop
@section('script')
@if(Auth::check())
$('.modal_trans_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	console.log("{{{ $_SERVER['REQUEST_URI']}}}"+'/'+this_action+'/'+this_id);
	if(this_id == '-1'){
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/transactions/'+this_action, function(data){
			$('#modalwindow').modal();
			$('#modalwindow').on('shown.bs.modal', function(){
				$('#modalwindow .load_modal').html(data);
				$('#datetimepicker1').datetimepicker({
					format: 'YYYY-MM-DD HH:mm:ss',
					pick12HourFormat: false
				});
			});
			$('#modalwindow').on('hidden.bs.modal',function(){
				$('#modalwindow .load_modal').html('');
			});
		});
	} else if (this_action === 'edit') {
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/'+this_action+'/'+this_id, function(data){
			$('#modalwindow').modal();
			$('#modalwindow').on('shown.bs.modal', function(){
				$('#modalwindow .load_modal').html(data);
				$('#datetimepicker1').datetimepicker({
					format: 'YYYY-MM-DD HH:mm:ss',
					pick12HourFormat: false
				});
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
@endif
@stop
@section('navbaritems')
	@if(Auth::check())
	@if($user->accounts->count())
	<button class="btn btn-primary btn-link navbar-btn modal_trans_btn" data-toggle="modal" data-id="-1" data-action="addtransaction"><b class="glyphicon glyphicon-plus"></b>Add transaction</button>
	@endif
	@endif
@stop
@section('content')
@if(Auth::check())
<div style="float:left; width: 50%; height:100%">
	<div class="panel panel-default" style="padding-left: 5px;float: left; margin-right: 15px; min-width: 100px; min-height: 100px">
		<div class="panel-header">
			<h2 style="float: left">Accounts Summary</h2> <h4 style="float:right"><a href="{{{ url('home/accounts')}}}" class="btn btn-primary btn-link">Manage Accounts</a></h4>
		</div>
		<hr style="clear: both"/>
		<div class="panel-body">
			@if($user->accounts->count())
			<table class="table table-hover ">
				<thead>
					<tr>
						<th>Type</th>
						<th>Institution</th>
						<th>Account name</th>
						<th>Description</th>
						<th>Balance</th>
						<th>Active</th>
						<!--<th>Options</th>-->
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
						<!--<td><button class="btn-link modal_account_btn" data-toggle="modal" data-id="{{{$account->id}}}" data-action="edit"><b class="glyphicon glyphicon-pencil"></b></button><button class="btn-link btn-danger modal_account_btn" data-toggle="modal" data-id="{{{$account->id}}}" data-action="delete"><b class="glyphicon glyphicon-trash" style="color:red"></b></button></td>-->
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
			@else
			<p>I See you don't have any accounts please click on the manage accounts button <b class="glyphicon glyphicon-arrow-up"> </b>.</p>
			@endif
		</div>
	</div>
	<div class="panel panel-default" style="padding-left: 5px;float: left; margin-right: 15px; min-width: 100px; min-height: 100px">
		<div class="panel-header">
			<h2 style="float: left">Budgets Summary</h2> <h4 style="float:right"><a href="{{{ url('home/accounts')}}}" class="btn btn-primary btn-link">Manage Budgets</a></h4>
		</div>
		<hr style="clear: both"/>
		<div class="panel-body">
			@if($user->accounts->count())
			<table class="table table-hover ">
				<thead>
					<tr>
						<th>Type</th>
						<th>Budget name</th>
						<th>Description</th>
						<th>Limit</th>
						<th>Amount against</th>
						<th>Active</th>
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
						</tr>
						@endif
					@endforeach			
				</tbody>
			</table>
			@else
			<p>I See you don't have any accounts please click on the manage accounts button <b class="glyphicon glyphicon-arrow-up"> </b>.</p>
			@endif
		</div>
	</div>
</div>
<div style="float:right; width: 50%; height:100%">
	<div class="panel panel-default" style="padding-left:5px; float: left; margin-right: 15px; min-width:100px; min-height: 100px">
		<div class="panel-header">
			<h2 style="float: left">Open Transaction Summary</h2> @if($user->accounts->count())<h4 style="float:right"><a href="{{{ url('home/transactions')}}}" class="btn btn-primary btn-link">Manage Transactions</a></h4>@endif
		</div>
		<hr style="clear: both"/>
		<div class="panel-body">
			@if($user->transactions->count())
			<table class="table table-hover ">
				<thead>
					<tr>
						<th>Date</th>
						<th>Type</th>
						<th>Store</th>
						<th>Discription</th>
						<th>Account</th>
						<th>Budget</th>
						<th>Ammount</th>
						<th>Posted</th>
					</tr>
				</thead>
				<tbody>
					@foreach($user->transactions as $trans)
					@if(!$trans->posted)
					<tr>
						<td>{{{$trans->date}}}</td>
						<td>{{{$trans->transtype->name}}}</td>
						<td>{{{$trans->store->name}}}</td>
						<td>{{{$trans->discription}}}</td>
						<td>{{{$trans->accounts->accountname}}}</td>
						@if($trans->budget)
						<td>{{{$trans->budget->accountname}}}</td>
						@else
						<td>No Budget</td>
						@endif
						@if($trans->transtype->is_credit)
						<td style="color:green">+<b class="glyphicon glyphicon-usd"></b>{{{$trans->amount}}}</td>
						@else
						<td style="color:red">-<b class="glyphicon glyphicon-usd"></b>{{{$trans->amount}}}</td>
						@endif
						<td>
							@if($trans->posted)
							<b class="glyphicon glyphicon-ok" style="color:green"></b>
							@else
						<b class="glyphicon glyphicon-remove" style="color:red"></b></td>
						@endif
					</td>
				</tr>
				@endif
				@endforeach
			</tbody>
		</table>
		@elseif($user->accounts->count())
		<p>I See you don't have any transactions please click on the manage transactions button <b class="glyphicon glyphicon-arrow-up"> </b>.</p>
		@endif
	</div>
</div>
<div class="panel panel-default" style="padding-left:5px; float: left; margin-right: 15px; min-width:100px; min-height: 100px">
	<div class="panel-header">
		<h2 style="float: left">Closed Transaction Summary</h2> @if($user->accounts->count())<h4 style="float:right"><a href="{{{ url('home/transactions')}}}" class="btn btn-primary btn-link">Manage Transactions</a></h4>@endif
	</div>
	<hr style="clear: both"/>
	<div class="panel-body">
		@if($user->transactions->count())
		<table class="table table-hover ">
			<thead>
				<tr>
					<th>Date</th>
					<th>Type</th>
					<th>Store</th>
					<th>Discription</th>
					<th>Account</th>
					<th>Budget</th>
					<th>Ammount</th>
					<th>Posted</th>
					<th>Date Posted</th>
				</tr>
			</thead>
			<tbody>
				@foreach($user->transactions as $trans)
				@if($trans->posted)
				<tr>
					<td>{{{$trans->date}}}</td>
					<td>{{{$trans->transtype->name}}}</td>
					<td>{{{$trans->store->name}}}</td>
					<td>{{{$trans->discription}}}</td>
					<td>{{{$trans->accounts->accountname}}}</td>
					@if($trans->budget)
					<td>{{{$trans->budget->accountname}}}</td>
					@else
					<td>No Budget</td>
					@endif
					@if($trans->transtype->is_credit)
					<td style="color:green">+<b class="glyphicon glyphicon-usd"></b>{{{$trans->amount}}}</td>
					@else
					<td style="color:red">-<b class="glyphicon glyphicon-usd"></b>{{{$trans->amount}}}</td>
					@endif
					<td>
						@if($trans->posted)
						<b class="glyphicon glyphicon-ok" style="color:green"></b>
						@else
					<b class="glyphicon glyphicon-remove" style="color:red"></b></td>
					@endif
				</td>
				<td>{{{$trans->dateposted}}}</td>
			</tr>
			@endif
			@endforeach
		</tbody>
	</table>
	@elseif($user->accounts->count())
	<p>I See you don't have any transactions please click on the manage transactions button <b class="glyphicon glyphicon-arrow-up"> </b>.</p>
	@endif
</div>
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