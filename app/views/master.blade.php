<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Tracker</title>
		<link rel="shortcut icon" href="{{{ url('http://test.xcesssoft.com/wp-content/uploads/2014/09/e-commerce.png') }}}">
		<link rel="stylesheet" href="{{{ url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css') }}}">
		<script type="text/javascript" src="{{ asset('jquery-2.1.1.min.js') }}"></script>
		<script src="{{ url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js') }}"></script>
		@if(!Auth::check())
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
		<style type="text/css">
		.popover{
			max-width: 100%;
			height: 180px;
		}
		</style>
		@else
		@yield('addheaddata')
		<script type="text/javascript">
		$(document).ready(function(){
					@yield('script')
				});
		</script>
		@endif
	</head>
	<body>
		<div class="container-fliud">
			<div class="page-header" style="padding-left:15%; width: 90%; margin: 0 auto; background-image: url('http://www.franchiseopportunitiesjournal.com/wp-content/uploads/2013/11/bigstock-Business-Graph-Output-Growth-O-38917468.jpg'); background-repeat: no-repeat; background-position: center; background-size: 50% 100%;">
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
						<a class="navbar-brand" href="{{{ url('home') }}}"><img alt="Brand" src="{{{ url('http://test.xcesssoft.com/wp-content/uploads/2014/09/e-commerce.png') }}}" style="width: 28px; height: 28px"></a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						@if(Auth::check())
						<a href="#" class="dropdown-toggle navbar-btn btn btn-primary btn-link" data-toggle="dropdown"><b class="glyphicon glyphicon-menu-hamburger"></b></a>
						<ul class="dropdown-menu" style="left:auto">
							@if(Auth::user()->isAdmin())
							<!-- put admin menu here if needed-->
							@else
							<li><a href="{{{ url('home/accounts') }}}"><b class="glyphicon glyphicon-briefcase"></b> Accounts</a></li>
							<li><a href="{{{ url('home/transactions') }}}"><b class="glyphicon glyphicon-shopping-cart"></b> Transactions</a></li>
							<li><a href="#"><b class="glyphicon glyphicon-menu-hamburger"></b></a></li>
							<li><a href="#"><b class="glyphicon glyphicon-menu-hamburger"></b></a></li>
							@endif
							@yield('addmenueitems')
						</ul>
						@yield('navbaritems')
						@endif
						@if(!Auth::check())
						<a href="#" class="login-popover btn btn-primary btn-link pull-right navbar-btn" valign="middle">Login</a>
						<div class="popover" id="login-popover-container">
							<div id="login-popover-head" class="popover-title">Please Login</div>
							<div id="login-popover-content" class="popover-content" style="width: 400px">
								{{ Form::open() }}
								<div class="form-horizontal" style="width: 100%">
									<div >
										{{ Form::text('username', Input::old('username'), array('placeholder'=>'Username',"class"=>"form-control", 0=>'required')) }}
									</div>
									<div>
										{{ Form::password('password', array('placeholder' => 'password',"class"=>"form-control", 0=>'required',"style"=>"margin-top:5px")) }}
									</div>
									<div class="form-group text-center">
										{{ Form::submit("Login" , array("class"=>"btn btn-primary", "style"=>"margin-top: 5px")) }}
									</div>
									{{ Form::close() }}
								</div>
							</div>
						</div>
						<!-- end popover content -->
						@else
						<a class="btn btn-primary btn-link navbar-btn pull-right" href="{{{ url('logout') }}}"> Logout </a>
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
						<div id="modalwindow" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" data-backdrop="static">
							<div class="modal-dialog" style="max-height: 65%; max-width: 100%; width: 35%;">
							<div class="modal-content load_modal" style="height: 100%">
							</div>
							</div>
						</div>
						@else
						@yield('nonauthcontent')
						@endif
					</div>
				</div>
			</body>
		</html>