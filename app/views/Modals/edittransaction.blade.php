@extends('modalmaster')
@section('modaltitle')
Add Transaction
@stop
@section('modalbodyfooter')
{{ Form::open(array('method'=>'post', 'url'=>'home/transactions/edit/'.$trans->id)) }}
<div class="modal-body" style="max-height: 75%">
	<div class="content form-horizontal">
		<div class="form-group">
			{{ Form::label('Transaction Type',null,array("class"=>"col-sm-3 control-label")) }}
			<div class="col-sm-7">
				{{ Form::select('transtype_id', $ttoptions,$trans->trans_type_id,array("class"=>"form-control tip", 'data-toggle'=>'tooltip', 'data-placement'=>'bottom','title'=>'This is a required field',0=>'required')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Store',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::select('store_id',$storeoptions,$trans->store_id,array("class"=>"form-control",0=>'required'))}}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Account',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::select('account_id',$accountoptions,$trans->accounts_id,array("class"=>"form-control",0=>'required'))}}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Budget',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-5">
				{{ Form::select('budget_id',$budgetoptions,$trans->budget_id,array("class"=>"form-control",0=>'required'))}}
			</div>
			
			{{Form::checkbox('counttobudget','true',($trans->budget_id?true:false))}}{{Form::label('Count tawords budget.',null,array("class"=>"control-label","style"=>"margin-left: 3px"))}}

		</div>
		<div class="form-group">
			{{ Form::label('Discription',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('discription', $trans->discription,array("class"=>"form-control",0=>'required')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Amount',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7">
				{{ Form::text('amount',$trans->amount,array("class"=>"form-control currency",0=>'required')) }}
			</div>
		</div>
		<div class="form-group">
			{{ Form::label('Date',null,array("class"=>"control-label col-sm-3")) }}
			<div class="col-sm-7 input-group date" id="datetimepicker1">
			{{ Form::text('date', $trans->date,array("id"=>"date" ,"class"=>"form-control","style"=>"z-index: 100", "data-format"=>'dd/MM/yyyy hh:mm:ss',0=>"required")) }}
				<span class="input-group-addon" style="min-width: 40px"><i class="glyphicon glyphicon-calendar"></i></span>
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