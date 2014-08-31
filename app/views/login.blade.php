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
					<div class="error-message" id="login-error"></div>
					<form id="login-form" action="" method="POST">
					<div class="row">
						<div class="col-md-3">Email</div>
						<div class="col-md-9"><input type="text" name="email" id="login-email" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Password</div>
						<div class="col-md-9"><input type="password" name="pass" id="login-pass" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3"><input type="submit" id="login-submit" class="login-submit" value="LOGIN" /></div>
					</div>
					</form>
				</div>
				<div class="tab-pane" id="register">
					<div class="error-message" id="register-error"></div>
					<div class="row">
						<div class="col-md-3">Name</div>
						<div class="col-md-9"><input type="text" name="reg-name" id="reg-name" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Email</div>
						<div class="col-md-9"><input type="text" name="reg-email" id="reg-email" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Password</div>
						<div class="col-md-9"><input type="password" name="reg-pass1" id="reg-pass1" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3">Confirm Password</div>
						<div class="col-md-9"><input type="password" name="reg-pass2" id="reg-pass2" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3"><input type="submit" id="register-submit" class="login-submit" value="REGISTER" /></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	$(document).ready(function() {
		$('#login-form').submit(function(e) {
			e.preventDefault();
			chk = app.checkFields([$('#login-email'), $('#login-pass')]);
			if(chk !== false) {
				$('#login-error').html('Please fill in the highlighted fields').addClass('show');
			} else {
				resp = app.sendPost($(this).attr('action'), $(this).serialize());
				resp.done(function(data) {
					if(data.status == 'success') { window.location.href = data.url; }
					else { $('#login-error').html(data.message).addClass('show'); }
				});
			}
		});

		$('#register-submit').click(function(e) {
			e.preventDefault();
			chk = app.checkFields([$('#reg-name'), $('#reg-email'), $('#reg-pass1'), $('#reg-pass2')]);
			if(chk !== false) {
				$('#register-error').html('Please fill in the highlighted fields').addClass('show');
			} else {
				resp = app.sendPost($(this).attr('action'), $(this).serialize());
				resp.done(function(data) {
					if(data.status == 'success') { window.location.href = data.url; }
					else { $('#register-error').html(data.message).addClass('show'); }
				});
			}
		});
	});
	</script>
</body>
</html>
