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
</head>
<body>
	<div id="mainwrap">
		<div id="logo"><img src="{{ asset('img/logo_large.png') }}" /></div>

		<div class="container-fluid login-container">
			<div id="tab-wrap">
			<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
				<li class="active"><a href="#login" data-toggle="tab">Login</a></li>
				<li><a href="#register" data-toggle="tab">Register</a></li>
			</ul>
			</div>
			<div class="tab-content">
				<div class="tab-pane active" id="login">
					<div class="row">
						<div class="col-md-3">Email</div>
						<div class="col-md-9"><input type="text" name="email" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Password</div>
						<div class="col-md-9"><input type="password" name="pass" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3"><input type="submit" class="login-submit" value="LOGIN" /></div>
					</div>
				</div>
				<div class="tab-pane" id="register">
					<div class="row">
						<div class="col-md-3">Name</div>
						<div class="col-md-9"><input type="text" name="s-name" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Email</div>
						<div class="col-md-9"><input type="text" name="s-email" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Password</div>
						<div class="col-md-9"><input type="password" name="s-pass1" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Confirm Password</div>
						<div class="col-md-9"><input type="password" name="s-pass2" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3"><input type="submit" class="login-submit" value="REGISTER" /></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
