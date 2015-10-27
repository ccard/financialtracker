@extends('modalmaster')
@section('modaltitle')
Post Transaction: "{{{$trans->discription}}}"
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/transactions/post/'.$trans->id)) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal">
		<div class="alert alert-warning">
			Post this transaction.  Once posted it cannot be deleted or edited.  You must create a reverse transaction!
		</div>
	</div>
</div>
<div class="modal-footer" style="max-height: 25%">
	<div class="text-center">
		{{ Form::submit('Post',array("class"=>"btn btn-primary btn-danger text-center")) }}
	</div>
</div>
{{ Form::close() }}
@stop