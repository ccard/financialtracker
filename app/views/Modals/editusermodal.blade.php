@extends('modalmaster')
@section('modaltitle')
Edit User
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/admin/user/edit/'.$user->id)) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal">
		<div class="form-group">
			{{ Form::label('First Name',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('firstname',$user->firstname,array("class"=>"form-control",0=>'required'))}}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Last Name',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('lastname', $user->lastname,array("class"=>"form-control",0=>'required')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Email',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('username', $user->username ,array("class"=>"form-control",0=>'required')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Privileges',null,array("class"=>"col-sm-3 control-label")) }}
			<div class="col-sm-7">
				{{ Form::select('privilage_id', $privilages,$user->privilage->id,array("class"=>"form-control tip", 'data-toggle'=>'tooltip', 'data-placement'=>'bottom','title'=>'This is a required field',0=>'required')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Password',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::password('password',array("class"=>"form-control",'placeholder'=>'Enter text here to change password')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Confirm Password',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::password('confpassword',array("class"=>"form-control")) }}
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