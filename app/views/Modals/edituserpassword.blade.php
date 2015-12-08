@extends('modalmaster')
@section('modaltitle')
Edit password
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/user/settings/editpassword')) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal" >
					<div class="form-group">
						{{ Form::label('Old password',null,array("class"=>"control-label col-sm-3"))}}
						<div class="col-sm-6">
							{{ Form::password('password',array("class"=>"form-control", 0=>'required'))}}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('New password',null,array("class"=>"control-label col-sm-3"))}}
						<div class="col-sm-6">
							{{ Form::password('newpassword',array("class"=>"form-control", 0=>'required'))}}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('Confirm password',null,array("class"=>"control-label col-sm-3"))}}
						<div class="col-sm-6">
							{{ Form::password('confirmpassword',array("class"=>"form-control", 0=>'required')) }}
						</div>
					</div>
				</div>
</div>
<div class="modal-footer" style="max-height: 25%">
	<div class="text-center">
		{{ Form::submit('Change',array("class"=>"btn btn-primary text-center")) }}
	</div>
</div>
{{ Form::close() }}
@stop