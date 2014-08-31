<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>TODO</title>
	<link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
	<div id="mainwrap">
		<div id="header">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-6">
						<div id="top-text">Welcome {{ Auth::user()->name }}!</div>
						<div id="top-links"><a id="settings-link">Settings</a> | <a href="{{ action('UserController@getLogout') }}">Logout</a></div></div>
					<div class="col-sm-6"><div id="hlogo"><img src="{{ asset('img/logo_large.png') }}" /></div></div>
				</div>
			</div>
		</div>
		<div id="error-message" class="container-fluid messagewrap">
			<div class="row">
			<div class="col-xs-4 col-xs-offset-4">
			<div id="error-box" class="message-box"></div>
			</div></div>
		</div>
		<div id="success-message" class="container-fluid messagewrap">
			<div class="row">
			<div class="col-xs-4 col-xs-offset-4">
			<div id="success-box" class="message-box">Success!</div>
			</div></div>
		</div>
		<div id="viewwrap">
			<div id="mainview" class="views">
				<div id="new-item-btn">New Item</div>
				<div class="container-fluid">
					<div class="row item-head">
						<div class="col-sm-8 col-xs-7">Title</div>
						<div class="col-xs-3">Due By</div>
						<div class="col-sm-1 col-xs-2">Status</div>
					</div>
					@if(count($items) > 0)
						@foreach($items as $item)
						<div class="row item-row">
							<div class="col-xs-8">$item->title</div>
							<div class="col-xs-3">$item->due</div>
							<div class="col-xs-1">$item->status</div>
						</div>
						@endforeach
					@else
					<div class="row empty-row">
						<div class="col-xs-12">No Items to Show!</div>
					</div>
					@endif
				</div>
			</div>

			<div id="leftview" class="views vhide">
				<div class="close-btn">Close</div>
				<div class="container-fluid">
					<form action="{{ action('UserController@postUpdate') }}" method="POST" id="user-update">
					<div class="row">
						<div class="col-md-3">Name</div>
						<div class="col-md-9"><input type="text" name="name" id="update-name" class="login-input" value="{{ Auth::user()->name }}" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Email</div>
						<div class="col-md-9"><input type="text" name="email" id="update-email" class="login-input" value="{{ Auth::user()->email }}" /></div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3"><input type="submit" id="update-submit" class="login-submit" value="UPDATE" /></div>
					</div>
					</form>
					<div class="row">
						<div class="col-md-12">&nbsp;</div>
					</div>
					<form action="{{ action('UserController@postUpdate') }}" method="POST" id="user-update-pass">
					<div class="row">
						<div class="col-md-3">New Password</div>
						<div class="col-md-9"><input type="password" name="pass1" id="update-pass1" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Confirm New Password</div>
						<div class="col-md-9"><input type="password" name="pass2" id="update-pass2" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3"><input type="submit" id="pass-submit" class="login-submit" value="UPDATE PASSWORD" /></div>
					</div>
					</form>
				</div>
			</div>

			<div id="rightview" class="views vhide">
				<div class="close-btn">Close</div>
				<div class="container-fluid">
				</div>
			</div>

			<div id="topview" class="views vhide">
				<div class="close-btn">Cancel</div>
				<div class="container-fluid">
				</div>
			</div>
		</div>
	</div>
	<script>
	$(document).ready(function() {
		app.setupForm($('#user-update'), [$('#update-name'), $('#update-email')], $('#error-box'), $('#success-box'));
		app.setupForm($('#user-update-pass'), [$('#update-pass1'), $('#update-pass2')], $('#error-box'), $('#success-box'));
		
		$('#settings-link').click(function() {
			app.loadPage($('#leftview'));
		});

		$('#new-item-btn').click(function() {
			app.loadPage($('#topview'));
		});

		$('.close-btn').click(function() {
			app.loadPage(app.lastview);
			app.lastview = $('#mainview');
		});
	});
	</script>
</body>
</html>
