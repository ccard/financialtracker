@extends('master')

@section('subHeading')
	Your project information
@stop
@section('optionGroup')
	<a class="btn btn-link" href="{{url('home/accountinfo')}}">Account Info </a>
@stop

@section('content')
	<p>hi</p>
@stop

@section('nonauthcontent')
	<p>yo</p>
@stop