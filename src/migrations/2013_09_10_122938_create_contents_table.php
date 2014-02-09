<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contents', function( Blueprint $t )
		{
			$t->increments('id');

			$t->string('title');
			$t->string('slug');

			$t->string('meta_title')->nullable();
			$t->string('meta_description')->nullable();

			$t->morphs('content');

			$t->timestamps();

			$t->integer('author_id')
				->unsigned();

			$t->unique( [ 'content_id', 'content_type' ] );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('contents');
	}

}
