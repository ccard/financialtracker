@extends('modalmaster')
@section('modaltitle')
Delete User {{{$user->username}}}
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/admin/user/delete/'.$user->id)) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal">
		<div class="alert alert-warning">
			You are about to delete this user and all records pertaining to them! <u><b class="color:red">THIS ACCTION CANNOT BE UNDONE!!!</b></u>
		</div>
	</div>
</div>
<div class="modal-footer" style="max-height: 25%">
	<div class="text-center">
		{{ Form::submit('Delete',array("class"=>"btn btn-primary btn-danger text-center")) }}
	</div>
</div>
{{ Form::close() }}
@stop