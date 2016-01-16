<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logins', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('UserID')->default(0);
            $table->string('ip')->default('0');
            $table->integer('Crawler')->default(0);
            $table->string('UserAgent')->default('');
            $table->string('Platform')->default('');
            $table->string('Browser')->default('');
            $table->string('BrowserFullName')->default('');
            $table->string('Device')->default('');
            $table->string('Pointing')->default('');
            $table->float('Accesses')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('logins');
    }
}
