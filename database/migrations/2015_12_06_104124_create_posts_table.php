<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('FormatID')->default(1);
            $table->integer('ThumbnailID');
            $table->integer('CourseID');
            $table->string('Title');
            $table->integer('FreeQuestions')->default(5);
            $table->string('Photo')->default(null);
            $table->string('Video')->default(null);
            $table->string('Description')->default(null);
            $table->integer('visited')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
