@extends('modalmaster')
@section('modaltitle')
Add Privilage
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/admin/privilage/add')) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal">
		<div class="form-group">
			{{ Form::label('Privilage',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('privilage',null,array("class"=>"form-control",0=>'required'))}}
			</div>
		</div>
	</div>
</div>
<div class="modal-footer" style="max-height: 25%">
	<div class="text-center">
		{{ Form::submit('Save',array("class"=>"btn btn-primary text-center")) }}
	</div>
</div>
{{ Form::close() }}
@stop