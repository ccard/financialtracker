@extends('master')
@section('script')
$('.modal_trans_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	if(this_action == 'add'){
	console.log("{{{ $_SERVER['REQUEST_URI']}}}"+'/user/trans/'+this_action);
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/admin/user/'+this_action, function(data){
			$('#modalwindow').modal();
			$('#modalwindow').on('shown.bs.modal', function(){
				$('#modalwindow .load_modal').html(data);
			});
			$('#modalwindow').on('hidden.bs.modal',function(){
				$('#modalwindow .load_modal').html('');
			});
		});
	} else {
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/user/trans/'+this_action+'/'+this_id, function(data){
			$('#modalwindow').modal();
			$('#modalwindow').on('shown.bs.modal', function(){
				$('#modalwindow .load_modal').html(data);
			});
			$('#modalwindow').on('hidden.bs.modal',function(){
				$('#modalwindow .load_modal').html('');
			});
		});
	}
});
$('.modal_account_btn').on('click',function(){
	var this_id = $(this).attr('data-id');
	var this_action = $(this).attr('data-action');
	console.log('here');
	if(this_action == 'add'){
		$.get("{{{ $_SERVER['REQUEST_URI']}}}"+'/user/account/'+this_action, function(data){
			$('#modalwindow').modal();
			$('#modalwindow').on('shown.bs.modal', function(){
				$('#modalwindow .load_modal').html(data);
			});
			$('#modalwindow').on('hidden.bs.modal',function(){
				$('#modalwindow .load_modal').html('');
			});
		});
	}
});
@stop
@section('menu')

@stop
@section('content')
		@if(Auth::check())
			@if($user->accounts->count())
				yah
			@else
				ah
			@endif
			@if($user->transactions->count())
				yaht
			@else
				aht
			@endif
		@endif
@stop
@section('nonauthcontent')
<div style="margin: 0 auto; width: 60%">
	<div class="box" style="float: left">
		<iframe src="http://www.engadget.com" width="500px" height="500px"></iframe>
	</div>
	<div class="box" style="float: left; margin-left: 20px">
		<iframe src="http://www.cad-comic.com/cad/" width="500px" height="500px"></iframe>
	</div>
</div>
@stop