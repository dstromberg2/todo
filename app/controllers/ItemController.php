<?php

class ItemController extends BaseController {

    public function __construct() {
		$this->beforeFilter('auth');
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
    	if(!Input::has('id') || Input::get('id') == '0') {
    		$item = new Item();
 	        $item->user_id = Auth::user()->id;
    	} else {
    		$item = Item::find(Input::get('id'));
    		if(is_null($item)) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        	if($item->user_id != Auth::user()->id) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        }
		   	// Run all the validation rules
     	   $validator = Validator::make(
            	array('title' => Input::get('title'),
      		      	'due' => Input::get('due'),
      		      	'status' => Input::get('status')),
            	array('title' => 'required',
            		'due' => 'required|date',
            		'status' => 'required')
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

    public function postStatus() {
    	if(!Input::has('id')) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
    	$item = Item::find(Input::get('id'));
    	if(is_null($item)) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        if($item->user_id != Auth::user()->id) {
            return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        } else {
		   	// Run the one validation rule
     	   $validator = Validator::make(
            	array('status' => Input::get('status')),
            	array('status' => 'required|boolean'));
        	// Send back the error messages if it fails
        	if($validator->fails()) return Response::json(array('status' => 'fail', 'message' => $validator->messages()));
 	        try {
    			$item->status = Input::get('status');
    			$item->save();
	    	} catch (Exception $e) {
    			return Response::json(array('status' => 'fail', 'message' => $e->getMessage()));
    		}

    		return Response::json(array('status' => 'success'));
        }
    }

}