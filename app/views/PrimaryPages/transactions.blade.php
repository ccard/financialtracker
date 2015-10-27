@extends('master')
@section('addheaddata')
<script type="text/javascript" src="{{ url('http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js') }}"></script>
<script src="{{ url('http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
@stop
@section('script')
$('.modal_trans_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	console.log("{{{ $_SERVER['REQUEST_URI']}}}"+'/'+this_action+'/'+this_id);
	if(this_id == '-1'){
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/'+this_action, function(data){
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
			@if($hastranstypes)
			<table class="table table-hover ">
				<thead>
					<tr>
						<th>Date</th>
						<th>Type</th>
						<th>Store</th>
						<th>Discription
						<th>Account</th>
						<th>Budget</th>
						<th>Ammount</th>
						<th>Posted</th>
						<th>Date Posted</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
					@foreach($user->transactions as $trans)
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
							@if(!$trans->posted)
							<td><button class="btn-link modal_trans_btn" data-toggle="modal" data-id="{{{$trans->id}}}" data-action="postone"><b style="color:green" class="glyphicon glyphicon-ok-sign"></b></button><button class="btn-link modal_trans_btn" data-toggle="modal" data-id="{{{$trans->id}}}" data-action="edit"><b class="glyphicon glyphicon-pencil"></b></button><button class="btn-link btn-danger modal_trans_btn" data-toggle="modal" data-id="{{{$trans->id}}}" data-action="delete"><b class="glyphicon glyphicon-trash" style="color:red"></b></button></td>
							@endif
						</tr>
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