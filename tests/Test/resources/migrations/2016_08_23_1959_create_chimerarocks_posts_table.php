<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChimerarocksPostsTable
{
	public function up()
	{
		Schema::create('chimerarocks_posts', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('chimerarocks_posts');
	}
}