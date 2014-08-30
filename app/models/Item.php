<?php

class Item extends Eloquent {

	protected $table = 'items';

	public function user() {
	    return $this->belongsTo('User');
	}
	
	public function taglinks() {
		return $this->hasMany('Taglink');
	}
}