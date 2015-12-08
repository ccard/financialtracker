@extends('modalmaster')
@section('modaltitle')
Edit user name
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/user/settings/editusername')) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal" >
					<div class="form-group">
						{{ Form::label('User name',null,array("class"=>"control-label col-sm-3"))}}
						<div class="col-sm-6">
							{{ Form::text('username', $username,array("class"=>"form-control", 0=>'required'))}}
						</div>
					</div>
</div>
<div class="modal-footer" style="max-height: 25%">
	<div class="text-center">
		{{ Form::submit('Update',array("class"=>"btn btn-primary text-center")) }}
	</div>
</div>
{{ Form::close() }}
@stop