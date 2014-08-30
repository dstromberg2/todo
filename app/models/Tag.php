<?php

class Tag extends Eloquent {

	protected $table = 'tags';

	public function user() {
	    return $this->belongsTo('User');
	}

	public function taglinks() {
		return $this->hasMany('Taglink');
	}
}