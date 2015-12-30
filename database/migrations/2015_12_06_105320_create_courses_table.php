<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Courses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('Title')->unique();
            $table->string('Description');
            $table->float('TotalHours')->default(0);
            $table->integer('NoOfUsers')->default(0);
            $table->integer('NoOfPosts')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Courses');
    }
}
