@extends('modalmaster')
@section('modaltitle')
Edit Account: {{{$account->accountname}}}
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/accounts/edit/'.$account->id)) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal">
		<div class="form-group">
			{{ Form::label('Account Type',null,array("class"=>"col-sm-3 control-label")) }}
			<div class="col-sm-7">
				{{ Form::select('accounttype_id', $actypeoptions,$account->account_type_id,array("class"=>"form-control tip", 'data-toggle'=>'tooltip', 'data-placement'=>'bottom','title'=>'This is a required field',0=>'required')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Institution',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::select('store_id',$storeoptions,$account->store->id,array("class"=>"form-control",0=>'required'))}}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Account Name',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('accountname', $account->accountname,array("class"=>"form-control",0=>'required')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Description',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('discription', $account->discription,array("class"=>"form-control",0=>'required')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Balance',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('balance',$account->balance,array("class"=>"form-control currency",0=>'required')) }}
			</div>
		</div>
		<div class="form-group text-center">
			{{Form::radio('active','active',($account->active?true:false))}}{{ Form::label('Active',null,array("class"=>"control-label")) }}
			{{Form::radio('active','notactive',($account->active?false:true))}}{{ Form::label('Not Active',null,array("class"=>"control-label")) }}
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