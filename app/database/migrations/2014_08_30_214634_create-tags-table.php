<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('tags', function($t) {
            $t->engine = 'InnoDb';
            $t->increments('id');
            $t->integer('user_id')->unsigned();
            $t->string('name', 64);
            $t->softDeletes();
            $t->timestamps();
            $t->foreign('user_id')->references('id')->on('users');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tags');
	}

}
