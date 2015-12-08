@extends('modalmaster')
@section('modaltitle')
Edit name
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/user/settings/edituserfullname')) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal" >
					<div class="form-group">
						{{ Form::label('First name',null,array("class"=>"control-label col-sm-3"))}}
						<div class="col-sm-6">
							{{ Form::text('firstname', $firstname,array("class"=>"form-control", 0=>'required'))}}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('Last name',null,array("class"=>"control-label col-sm-3"))}}
						<div class="col-sm-6">
							{{ Form::text('lastname', $lastname,array("class"=>"form-control", 0=>'required'))}}
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