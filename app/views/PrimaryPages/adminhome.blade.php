@extends('master')
@section('script')
	$('.modal_usr_btn').on('click',function(){
		var this_id = $(this).attr('data-id');
		var this_action = $(this).attr('data-action');
		console.log('here');
		if(this_action == 'add'){
			$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/admin/user/'+this_action, function(data){
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
	<div style="float: left">
		@if(count($users))
		<h2>Users</h2>
		<button id="addUser" class="btn-link pull-right modal_usr_btn" data-toggle="modal" data-id="" data-action="add"><b class="glyphicon glyphicon-plus"></b>Add user</button>
		<div class="table table-hover table-condensed">
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
			
		</tbody>
		</div>
		@else
		<h2>Users</h2>
		<a id="addUser" class="btn-link pull-right modal_usr_btn" data-toggle="modal" data-id="" data-action="add"><b class="glyphicon glyphicon-plus"></b>Add user</a>
		@endif
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