@extends('master')
@section('addheaddata')
@if(Auth::check())
<script type="text/javascript" src="{{ url('http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js') }}"></script>
<script src="{{ url('http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
@endif
@stop
@section('script')
$('.modal_accountinfo_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	
	if(this_action == 'add'){
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/accountinfo/'+this_action, function(data){
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
@stop
@section('content')
<div class="content" style="margin-left: 10px">
			<div class="form-horizontal">
				<div class="page-header">
					<h2>Personal Information</h2>
				</div>
				<div class="form-group">
					{{ Form::label('Name',null,array("class"=>"control-label col-sm-2"))}}
					<div class="col-sm-10">
						{{ Form::text('name',$user->firstname.' - '.$user->lastname,array("class"=>"form-control",'readonly'=>"readonly",0=>'disabled')) }}  
						<button class="btn btn-primary btn-link navbar-btn modal_accountinfo_btn" data-toggle="modal" data-id="-1" data-action="editname"><b class="glyphicon glyphicon-pencil"></b>Edit name</button>
					</div>
				</div>
				<div class="form-group">
					{{Form::label('Email',null,array("class"=>"control-label col-sm-2")) }}
					<div class="col-sm-10">
						{{ Form::text('username',$user->username,array("class"=>"form-control",'readonly'=>"readonly",0=>'disabled')) }}
						<button class="btn btn-primary btn-link navbar-btn modal_accountinfo_btn" data-toggle="modal" data-id="-1" data-action="edituname"><b class="glyphicon glyphicon-pencil"></b>Edit user name</button>
					</div>
				</div>
				<div class="form-group" style="margin-left: 10px">
					<label class="control-label col-sm-2">Password </label>
					<button class="btn btn-primary btn-link navbar-btn modal_accountinfo_btn" data-toggle="modal" data-id="-1" data-action="editpassword"><b class="glyphicon glyphicon-pencil"></b>Edit password</button>
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