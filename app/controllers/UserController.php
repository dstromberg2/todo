<?php

class UserController extends BaseController {

    public function __construct() {
		$this->beforeFilter('auth', array('except' => array('postLogin', 'postNew')));
    }

    public function postNew() {
    	// Run all the validation rules
        $validator = Validator::make(
            array('email' => Input::get('email'),
            	'name' => Input::get('name'),
            	'pass1' => Input::get('pass1'),
            	'pass2' => Input::get('pass2')),
            array('email' => 'required|email|unique:users',
            	'name' => 'required',
            	'pass1' => 'required',
            	'pass2' => 'required|same:pass1')
        );
        // Send back the error messages if it fails
        if($validator->fails()) return Response::json(array('status' => 'fail', 'message' => $validator->messages()));

        // Otherwise, create the new user
        $user = new User();
        $user->name = Input::get('name');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('pass1'));
        $user->save();

        // And log them in
        Auth::login($user);
        // Then send the redirect URL
    	return Response::json(array('status' => 'success', 'url' => route('app')));
    }
    
    public function postLogin() {
    	$user = array('email' => Input::get('email'), 'password' => Input::get('pass'));
        if(!Auth::attempt($user)) {
        	return Response::json(array('status' => 'fail', 'message' => 'Invalid email/password'));
        } else {
        	return Response::json(array('status' => 'success', 'url' => route('app')));
        }
    }

    public function postUpdate() {
    	// Run the validation checks
    	$validator = Validator::make(
    		array('email' => Input::get('email'),
    			'pass1' => Input::get('pass1'),
    			'pass2' => Input::get('pass2')),
    		array('email' => 'email|unique:users',
    			'pass2' => 'same:pass1')
    	);
    	// Send back the error message if it fails
    	if($validator->fails()) return Response::json(array('status' => 'fail', 'message' => $validator->messages()));

    	// Update only on the fields which have been sent
    	if(Input::has('email')) Auth::user()->email = Input::get('email');
    	if(Input::has('name')) Auth::user()->name = Input::get('name');
    	if(Input::has('pass1')) Auth::user()->password = Hash::make(Input::get('pass1'));
    	Auth::user()->save();
    	return Response::json(array('status' => 'success'));
    }

    public function getLogout() {
    	Auth::logout();
    	return Redirect::route('/');
    }

}