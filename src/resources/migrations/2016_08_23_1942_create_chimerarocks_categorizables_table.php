<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChimerarocksCategorizablesTable
{
	public function up()
	{
		Schema::create('chimerarocks_categorizables', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('category_id');
			$table->integer('categorizable_id');
			$table->integer('categorizable_type');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('chimerarocks_categorizables');
	}
}