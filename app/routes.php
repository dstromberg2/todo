<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => '/', function()
{
	return View::make('login');
}));

Route::get('app', array('as' => 'approute', 'before' => 'auth', function() {
	$data['items'] = Item::where('user_id', Auth::user()->id)->orderBy('due', 'DESC')->get();
	return View::make('main', $data);
}));

Route::controller('user', 'UserController');
Route::controller('item', 'ItemController');
Route::controller('tag', 'TagController');