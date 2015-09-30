@extends('master')
@section('script')
$('.modal_usr_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	if(this_action == 'add'){
	console.log("{{{ $_SERVER['REQUEST_URI']}}}"+'/admin/user/'+this_action);
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/admin/user/'+this_action, function(data){
			$('#modalwindow').modal();
			$('#modalwindow').on('shown.bs.modal', function(){
				$('#modalwindow .load_modal').html(data);
			});
			$('#modalwindow').on('hidden.bs.modal',function(){
				$('#modalwindow .load_modal').html('');
			});
		});
	} else {
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/admin/user/'+this_action+'/'+this_id, function(data){
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
$('.modal_priv_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	console.log('here');
	if(this_action == 'add'){
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/admin/privilage/'+this_action, function(data){
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
@section('menu')
@stop
@section('content')
<div style="margin: 0 auto; width = 80%">
	<div class="panel panel-default" style="float: left">
		<div class="panel-body">
			@if(count($users))
			<h2>Users</h2>
			<button id="addUser" class="btn-link pull-right modal_usr_btn" data-toggle="modal" data-id="" data-action="add"><b class="glyphicon glyphicon-plus"></b>Add user</button>
			<table class="table table-hover ">
				<thead>
					<tr>
						<th>Username</th>
						<th>First name</th>
						<th>Last name</th>
						<th>Privilage</th>
						<th>Options</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td>{{{$user->username}}}</td>
							<td>{{{$user->firstname}}}</td>
							<td>{{{$user->lastname}}}</td>
							<td>{{{$user->privilage->name}}}</td>
							<td><button class="btn-link modal_usr_btn" data-toggle="modal" data-id="{{{$user->id}}}" data-action="edit"><b class="glyphicon glyphicon-pencil"></b></button><button class="btn-link btn-danger modal_usr_btn" data-toggle="modal" data-id="{{{$user->id}}}" data-action="delete"><b class="glyphicon glyphicon-trash" style="color:red"></b></button></td>
						</tr>
					@endforeach			
				</tbody>
			</table>
			@else
			<h2>Users</h2>
			<a id="addUser" class="btn-link pull-right modal_usr_btn" data-toggle="modal" data-id="" data-action="add"><b class="glyphicon glyphicon-plus"></b>Add user</a>
			@endif
		</div>
	</div>
	<div class="panel panel-default" style="float: left; margin-left: 30px">
		<div class="panel-body">
			@if(count($privs))
			<h2>Privilages</h2>
			<button id="addPriv" class="btn-link pull-right modal_priv_btn" data-toggle="modal" data-id="" data-action="add"><b class="glyphicon glyphicon-plus"></b>Add Privilage</button>
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					@foreach($privs as $priv)
					<tr>
						<td>{{{ $priv->name }}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
			<h2>Privilages</h2>
			<a id="addPriv" class="btn-link pull-right modal_priv_btn" data-toggle="modal" data-id="" data-action="add"><b class="glyphicon glyphicon-plus"></b>Add Privilage</a>
			@endif
		</div>
	</div>
</div>
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