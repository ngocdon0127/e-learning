<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Formats', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('Title');
            $table->string('Description');
            $table->string('Format');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Formats');
    }
}
