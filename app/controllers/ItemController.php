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
    	$items = Item::where('user_id', Auth::user()->id);
    	if(Input::has('completed')) {
    		if(Input::get('completed') !== true) $items->where('status', false);
    	} else {
    		$items->where('status', false);
    	}
    	if(Input::has('order')) {
    		switch(Input::get('order')) {
    			case 1:
    				$items->orderBy('due');
    				break;
    			case 2:
    				$items->orderBy('status');
    				break;
    			case 0:
    			default:
    				$items->orderBy('title');
    				break;
    		}
    	} else { $items->orderBy('title'); }
    	$items->get();
    	return Response::json(array('status' => 'success', 'items' => $items));
    }

    public function getView() {
    	if(!Input::has('id')) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
    	$item = Item::with('user')->find(Input::get('id'));
    	if(is_null($item)) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        if($item->user_id != Auth::user()->id) {
            return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        } else {
        	return Response::json(array('status' => 'success', 'item' => $item));
        }
    }

    public function getEdit() {
    	if(!Input::has('id')) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
    	$item = Item::find(Input::get('id'));
    	if(is_null($item)) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        if($item->user_id != Auth::user()->id) {
            return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        } else {
        	return Response::json(array('status' => 'success', 'item' => $item));
        }
    }

    public function postEdit() {
    	if(!Input::has('id')) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
    	$item = Item::find(Input::get('id'));
    	if(is_null($item)) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        if($item->user_id != Auth::user()->id) {
            return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        } else {
		   	// Run all the validation rules
     	   $validator = Validator::make(
            	array('title' => Input::get('title'),
      		      	'due' => Input::get('due'),
      		      	'status' => Input::get('status')),
            	array('title' => 'required',
            		'due' => 'required|date',
            		'status' => 'boolean')
        	);
        	// Send back the error messages if it fails
        	if($validator->fails()) return Response::json(array('status' => 'fail', 'message' => $validator->messages()));
 	       try {
    			$item->title = Input::get('title');
	    		$item->body = Input::get('body');
    			$item->due = Input::get('due');
    			$item->status = Input::get('status');
    			$item->save();
	    	} catch (Exception $e) {
    			return Response::json(array('status' => 'fail', 'message' => $e->getMessage()));
    		}

    		return Response::json(array('status' => 'success'));
        }
    }

}