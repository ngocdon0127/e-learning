<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('licenses', function (Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('key')->unique();
			$table->string('serial')->unique();
			$table->integer('Sold')->default(0);
			$table->integer('Activated')->default(0);
			$table->integer('Duration')->default(8760);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('licenses');
	}
}
