<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagLinkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('taglinks', function($t) {
            $t->engine = 'InnoDb';
            $t->increments('id');
            $t->integer('item_id')->unsigned();
            $t->integer('tag_id')->unsigned();
            $t->timestamps();
            $t->foreign('item_id')->references('id')->on('items');
            $t->foreign('tag_id')->references('id')->on('tags');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('taglinks');
	}

}
