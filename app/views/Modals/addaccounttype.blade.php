@extends('modalmaster')
@section('modaltitle')
Add Account Type
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/accounts/addaccounttype')) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal">
		<div class="form-group">
			{{ Form::label('Account type',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('accounttype',null,array("class"=>"form-control",0=>'required'))}}
				{{ Form::checkbox('isbudget','true',false)}} {{ Form::label('Is Budget',null,array("class"=>"control-label")) }}
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