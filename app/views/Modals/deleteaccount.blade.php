@extends('modalmaster')
@section('modaltitle')
Delete Account {{{$account->accountname}}}
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/accounts/delete/'.$account->id)) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal">
		<div class="alert alert-warning">
			If you choose to delete the account then all transactions associated with the account will be deleted! <u><b class="color:red">THIS ACCTION CANNOT BE UNDONE!!!</b></u>
			Or you can deactivate the account!
		</div>
		<div class="form-group text-center">
		{{ Form::radio('delete','delete') }} {{Form::label('Delete Account',null,array("class"=>"control-label"))}}
		{{ Form::radio('delete','deactivate',true)}} {{Form::label('Deactivate Account',null,array("class"=>"control-label"))}}
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