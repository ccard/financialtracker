<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Tracker</title>
		<link rel="shortcut icon" href="{{{ url('http://test.xcesssoft.com/wp-content/uploads/2014/09/e-commerce.png') }}}">
		<link rel="stylesheet" href="{{{ url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css') }}}">
		<script type="text/javascript" src="{{ asset('jquery-2.1.1.min.js') }}"></script>
		<script src="{{ url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript">
						$(document).ready(function(){
							$('.login-popover').popover({
								html: true,
								placement: "auto",
								viewport: 'body',
								content: $('#login-popover-content').html(),
								title: $('#login-popover-head').html()
							});
						});
							
		</script>
		@if(!Auth::check())
		<style type="text/css">
		.popover{
			max-width: 100%;
			height: 180px;
		}
		</style>
		@endif
	</head>
	<body>
		<div class="container-fliud">
			<div class="page-header" style="padding-left:15%; width: 90%; margin: 0 auto; background-image: url('http://www.franchiseopportunitiesjournal.com/wp-content/uploads/2013/11/bigstock-Business-Graph-Output-Growth-O-38917468.jpg'); background-repeat: no-repeat; background-position: center; background-size: 50% 100%;">
				@if(Auth::check())
				@yield('backButton')
				@endif
				<h1 style="height: 50px">Financial Tracker</small>
				</h1>
			</div>
			<nav class="navbar navbar-default" style=" margin-right: 1%; margin-left: 1%; background-color:#fff; board-color: #fff">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{{{ url('home') }}}"><img alt="Brand" src="{{{ url('http://test.xcesssoft.com/wp-content/uploads/2014/09/e-commerce.png') }}}" style="width: 32px; height: 32px"></a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="dropdown-menu">
							<!-- Replace with my list -->
						</ul>
						@if(!Auth::check())
						<a href="#" class="login-popover btn btn-primary btn-link pull-right navbar-btn" valign="middle">Login</a>
						<div class="popover" id="login-popover-container">
							<div id="login-popover-head" class="popover-title">Please Login</div>
							<div id="login-popover-content" class="popover-content" style="width: 400px">
								{{ Form::open() }}
								<div class="form-horizontal" style="width: 100%">
									<!-- <div class="col-lg-2"></div> -->
									<!-- <div class="form-group">
										{{Form::label('username','User name:',array("class"=>" control-label"))}} -->
										<div >
											{{ Form::text('username', Input::old('username'), array('placeholder'=>'Username',"class"=>"form-control", 0=>'required')) }}
										</div>
									<!-- </div> -->
									<!-- <div class="col-lg-2"></div> -->
									<!--<div class="form-group">
										{{ Form::label('password','Password:',array("class"=>"col-sm-2 control-label")) }} -->
										<div>
											{{ Form::password('password', array('placeholder' => 'password',"class"=>"form-control", 0=>'required',"style"=>"margin-top:5px")) }}
										</div>
									<!-- </div> -->
									<div class="form-group text-center">
										{{ Form::submit("Login" , array("class"=>"btn btn-primary", "style"=>"margin-top: 5px")) }}
									</div>
									{{ Form::close() }}
								</div>
							</div>
						</div>
						<!-- end popover content -->
						@else
						<a class="btn btn-primary btn-link" href="{{{ url('logout') }}}"> logout </a>
						@endif
						</div><!-- /.navbar-collapse -->
						</div><!-- /.container-fluid -->
					</nav>
					<div class="container-fluid" style="padding-left: 4%; padding-right:4%">
						@if(Session::has('message'))
						<div class="alert alert-success">
							{{{ Session::get('message') }}}
						</div>
						@endif
						@if(Session::has('error'))
						<div class="alert alert-warning">
							{{{ Session::get('error') }}}
						</div>
						@endif
						@if(Auth::check())
						@yield('content')
						<script type="text/javascript">
						@yield('script')
						</script>
						@else
						@yield('nonauthcontent')
						@endif
					</div>
				</div>
			</body>
		</html>