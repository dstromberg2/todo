<?php

class ItemController extends BaseController {

    public function __construct() {
		$this->beforeFilter('auth');
    }

    public function postNew() {
    	// Run all the validation rules
        $validator = Validator::make(
            array('title' => Input::get('title'),
            	'due' => Input::get('due')),
            array('title' => 'required',
            	'due' => 'required|date')
        );
        // Send back the error messages if it fails
        if($validator->fails()) return Response::json(array('status' => 'fail', 'message' => $validator->messages()));

        try {
    		$item = new Item();
    		$item->user_id = Auth::user()->id;
    		$item->title = Input::get('title');
    		$item->body = Input::get('body');
    		$item->due = Input::get('due');
    		$item->status = false;
    		$item->save();
    	} catch (Exception $e) {
    		return Response::json(array('status' => 'fail', 'message' => $e->getMessage()));
    	}

    	return Response::json(array('status' => 'success'));
    }

    public function getList() {

    }

    public function getView() {

    }

    public function getEdit() {

    }

    public function postEdit() {

    }

}