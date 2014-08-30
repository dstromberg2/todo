<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('items', function($t) {
            $t->engine = 'InnoDb';
            $t->increments('id');
            $t->integer('user_id')->unsigned();
            $t->string('title');
            $t->text('body');
            $t->dateTime('due');
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
		Schema::drop('items');
	}

}
