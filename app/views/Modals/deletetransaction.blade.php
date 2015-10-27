@extends('modalmaster')
@section('modaltitle')
Delete Transaction {{{$trans->discription}}}
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/transactions/delete/'.$trans->id)) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal">
		<div class="alert alert-warning">
			This trans acction will be permently deleted!
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