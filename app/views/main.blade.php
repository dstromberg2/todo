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
		<div id="viewwrap">
			<div id="mainview" class="views">
				<div id="new-item-btn">New Item</div>
				<div class="container-fluid">
					<div class="row item-head">
						<div class="col-sm-8 col-xs-7">Title</div>
						<div class="col-xs-3">Due By</div>
						<div class="col-sm-1 col-xs-2">Status</div>
					</div>
					@if(count(Auth::user()->items) > 0)
						@foreach(Auth::user()->items as $item)
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

			<div id="leftview" class="views">
				<div class="container-fluid">
				</div>
			</div>

			<div id="rightview" class="views">
				<div class="container-fluid">
				</div>
			</div>

			<div id="topview" class="views">
				<div class="container-fluid">
				</div>
			</div>
		</div>
	</div>
</body>
</html>
