<?php

class TagController extends BaseController {

    public function __construct() {
		$this->beforeFilter('auth');
    }

    public function postNew() {
        // Run all the validation rules
        $validator = Validator::make(
            array('name' => Input::get('name')),
            array('name' => 'required')
        );
        // Send back the error messages if it fails
        if($validator->fails()) return Response::json(array('status' => 'fail', 'message' => $validator->messages()));

        try {
            $tag = new Tag();
            $tag->user_id = Auth::user()->id;
            $tag->title = Input::get('name');
            $tag->save();
        } catch (Exception $e) {
            return Response::json(array('status' => 'fail', 'message' => $e->getMessage()));
        }

        return Response::json(array('status' => 'success'));
    }

    public function getList() {
        $tags = Tag::where('user_id', Auth::user()->id)->orderBy('name', 'ASC')->get();
        return Response::json(array('status' => 'success', 'tags' => $tags));
    }

    public function postAssign() {
        $tag = Tag::find(Input::get('tag_id'));
        $item = Item::find(Input::get('item_id'));
        if($item->user_id != Auth::user()->id || $tag->user_id != Auth::user()->id) {
            return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        } else {
           try {
                $tl = new Taglink();
                $tl->item_id = $item->id;
                $tl->tag_id = $tag->id;
                $tl->save();
            } catch (Exception $e) {
                return Response::json(array('status' => 'fail', 'message' => $e->getMessage()));
            }
            return Response::json(array('status' => 'success'));
        }
    }

    public function postUnassign() {
        $tl = Taglink::find(Input::get('id'));
        if($tl->item()->user_id != Auth::user()->id || $tl->tag()->user_id != Auth::user()->id) {
            return Response::json(array('status' => 'fail', 'message' => 'Unauthorized Access'));
        } else {
            try {
                $tl->delete();
            } catch (Exception $e) {
                return Response::json(array('status' => 'fail', 'message' => $e->getMessage()));
            }
            return Response::json(array('status' => 'success'));
        }
    }

}