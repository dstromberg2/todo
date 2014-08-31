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
						<div id="top-links"><a href="">Settings</a> | <a href="{{ action('UserController@getLogout') }}">Logout</a></div></div>
					<div class="col-sm-6"><div id="hlogo"><img src="{{ asset('img/logo_large.png') }}" /></div></div>
				</div>
			</div>
		</div>
		<div id="viewwrap">
			<div id="mainview">
				<div class="container-fluid">
				</div>
			</div>

			<div id="leftview">
				<div class="container-fluid">
				</div>
			</div>

			<div id="rightview">
				<div class="container-fluid">
				</div>
			</div>

			<div id="topview">
				<div class="container-fluid">
				</div>
			</div>
		</div>
	</div>
</body>
</html>
