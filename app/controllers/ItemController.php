<?php

class ItemController extends BaseController {

    public function __construct() {
		$this->beforeFilter('auth');
    }

    public function getList() {
    	$items = Item::where('user_id', Auth::user()->id);
/*    	if(Input::has('completed')) {
    		if(Input::get('completed') !== true) $items->where('status', false);
    	} else {
    		$items->where('status', false);
    	}
*/
    	if(Input::has('dir') && (Input::get('dir') == 'ASC' || Input::get('dir') == 'DESC')) {
    		$dir = Input::get('dir');
    	} else {
    		$dir = 'ASC';
    	}
    	if(Input::has('order')) {
    		switch(Input::get('order')) {
    			case 1:
    				$items->orderBy('title', $dir);
    				break;
    			case 2:
    				$items->orderBy('status', $dir);
    				break;
    			case 0:
    			default:
    				$items->orderBy('due', $dir);
    				break;
    		}
    	} else { $items->orderBy('due', $dir); }

    	return View::make('itemrows', array('items' => $items->get()));
    }

    public function getView() {
    	if(!Input::has('id')) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
    	$item = Item::with('user')->with(array('taglinks' => function($q){ $q->with('tag'); }))->find(Input::get('id'));
    	if(is_null($item)) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        if($item->user_id != Auth::user()->id) {
            return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        } else {
        	return Response::json(array('status' => 'success', 'item' => $item));
        }
    }

    public function getEdit() {
    	if(!Input::has('id')) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
    	$item = Item::with(array('taglinks' => function($q){ $q->with('tag'); }))->find(Input::get('id'));
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
    			$item->status = (Input::get('status') == 'true' ? 1 : 0);
    			$item->save();
	    	} catch (Exception $e) {
    			return Response::json(array('status' => 'fail', 'message' => $e->getMessage()));
    		}

    		return Response::json(array('status' => 'success'));
    }

    public function postQuickNew() {
    	$item = new Item();
    	$item->user_id = Auth::user()->id;
    	$item->save();
    	return Response::json(array('status' => 'success', 'item' => $item));
    }

    public function postDelete() {
    	if(!Input::has('id')) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
    	$item = Item::find(Input::get('id'));
    	if(is_null($item)) return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
    	try {
    		foreach($item->taglinks as $tag) {
    			$tag->delete();
    		}
    		$item->delete();
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
            	array('status' => 'required'));
        	// Send back the error messages if it fails
        	if($validator->fails()) return Response::json(array('status' => 'fail', 'message' => $validator->messages()));
 	        try {
    			$item->status = (Input::get('status') == 'true' ? 1 : 0);
    			$item->save();
	    	} catch (Exception $e) {
    			return Response::json(array('status' => 'fail', 'message' => $e->getMessage()));
    		}

    		return Response::json(array('status' => 'success'));
        }
    }

}