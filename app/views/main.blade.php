<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>TODO</title>
	<link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ asset('css/DateTimePicker.min.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/DateTimePicker.min.js') }}"></script>
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
						<div class="col-sm-8 col-xs-7 sortrow" data-sort="1" data-dir="ASC">Title</div>
						<div class="col-xs-3 sortrow active" data-sort="0" data-dir="ASC">Due By</div>
						<div class="col-sm-1 col-xs-2 sortrow" data-sort="2" data-dir="ASC">Status</div>
					</div>
					<div id="rowwrap">
					@if(count($items) > 0)
						@foreach($items as $item)
						<div class="row item-row" data-id="{{ $item->id }}">
							<div class="col-sm-8 col-xs-7">{{ $item->title }}</div>
							<div class="col-xs-3">{{ $item->due }}</div>
							<div class="col-sm-1 col-xs-2">
								<input type="radio" class="inrow @if($item->status == 0)radio-false @endif" checked readonly /><label><span><span></span></span></label></div>
						</div>
						@endforeach
					@else
					<div class="row empty-row">
						<div class="col-xs-12">No Items to Show!</div>
					</div>
					@endif
					</div>
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
				<div id="item-edit-btn" class="top-submit">Edit Item</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-3 item-label">Title</div>
						<div class="col-md-9" id="item-show-title"></div>
					</div>
					<div class="row">
						<div class="col-md-3 item-label">Description</div>
						<div class="col-lg-7 col-md-9" id="item-show-body"></div>
					</div>
					<div class="row">
						<div class="col-md-3 item-label">Due By</div>
						<div class="col-md-9" id="item-show-due"></div>
					</div>
					<div class="row">
						<div class="col-md-3 item-label">Status</div>
						<div class="col-md-9 item-radios"><input type="radio" id="item-show-status-false" class="radio-false" value="false" checked readonly /><label for="item-show-status-false"><span><span></span></span>Pending</label><input type="radio" id="item-show-status-true" value="true" checked readonly /><label for="item-show-status-true"><span><span></span></span>Completed</label></div>
					</div>
					<div class="row">
						<div class="col-md-3 item-label">Author</div>
						<div class="col-md-9" id="item-show-author"></div>
					</div>
				</div>
			</div>

			<div id="topview" class="views vhide">
				<form action="{{ action('ItemController@postEdit') }}" method="POST" id="item-edit">
				<input type="submit" id="item-save" class="top-submit" value="SAVE" />
				<div class="close-btn">Cancel</div>
				<div class="container-fluid">
					<input type="hidden" name="id" value="0" id="item-edit-id" />
					<div class="row">
						<div class="col-md-3 item-label">Title</div>
						<div class="col-md-9"><input type="text" name="title" id="item-edit-title" class="login-input" /></div>
					</div>
					<div class="row">
						<div class="col-md-3 item-label">Description</div>
						<div class="col-md-9"><textarea name="body" id="item-edit-body" rows="5" class="item-text"></textarea></div>
					</div>
					<div class="row">
						<div class="col-md-3 item-label">Due By</div>
						<div class="col-md-9"><input type="text" name="due" id="item-edit-due" class="item-due-input" data-field="datetime" data-format="yyyy-MM-dd HH:mm:ss" readonly /></div>
						<div id="dtBox"></div>
					</div>
					<div class="row">
						<div class="col-md-12">&nbsp;</div>
					</div>
					<div class="row">
						<div class="col-md-3 item-label">Status</div>
						<div class="col-md-9 item-radios"><input type="radio" name="status" id="item-edit-status-false" class="radio-false" value="false" checked /><label for="item-edit-status-false"><span><span></span></span>Pending</label><input type="radio" name="status" id="item-edit-status-true" value="true" /><label for="item-edit-status-true"><span><span></span></span>Completed</label></div>
					</div>
					<div class="row">
						<div class="col-md-12">&nbsp;</div>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
	<script>
	$(document).ready(function() {
		app.itemurl = "{{ action('ItemController@getView') }}";
		app.rowurl = "{{ action('ItemController@getList') }}";
		app.setupForm($('#user-update'), [$('#update-name'), $('#update-email')], $('#error-box'), $('#success-box'));
		app.setupForm($('#user-update-pass'), [$('#update-pass1'), $('#update-pass2')], $('#error-box'), $('#success-box'));
		app.setupForm($('#item-edit'), [$('#item-edit-title'), $('#item-edit-due')], $('#error-box'), $('#success-box'), function() {
			app.loadRows();
			app.loadView($('#item-edit-id').val());
			app.loadPage(app.lastview);
			app.lastview = $('#mainview');
		});
		$('#dtBox').DateTimePicker({'dateTimeFormat': 'yyyy-MM-dd HH:mm:ss'});
		
		$(document).on('click', '.item-row', function() {
			app.loadView($(this).data('id'), function() {
				app.loadPage($('#rightview'));
			});
		});

		$('.sortrow').click(function() {
			app.sortRows($(this));
		});

		$('#item-edit-btn').click(function() {
			app.loadEdit($(this).data('id'), function() {
				app.loadPage($('#topview'));
			});
		});

		$('#settings-link').click(function() {
			app.loadPage($('#leftview'));
		});

		$('#new-item-btn').click(function() {
			app.clearEdit();
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
