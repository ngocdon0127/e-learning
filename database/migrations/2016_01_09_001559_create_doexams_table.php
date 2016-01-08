<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoexamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doexams', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('PostID');
            $table->integer('UserID');
            $table->integer('Score')->default(-1);
            $table->float('Time')->default(0);
            $table->string('token')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('doexams');
    }
}
