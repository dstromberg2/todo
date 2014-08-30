<?php

class Taglink extends Eloquent {

	protected $table = 'taglinks';

	public function item() {
	    return $this->belongsTo('Item');
	}

	public function tag() {
	    return $this->belongsTo('Tag');
	}

		
}