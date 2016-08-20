<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChimerarocksCategoriesTable
{
	public function up()
	{
		Schema::create('chimerarocks_categories', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('parent_id')->nullable(true)->unsigned();
			$table->foreign('parent_id')->references('id')->on('chimerarocks_categories');
			$table->string('name');
			$table->string('slug');
			$table->boolean('active')->default(false);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('chimerarocks_categories');
	}
}