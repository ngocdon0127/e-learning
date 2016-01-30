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
            $table->string('LastURI')->default(null);
            $table->string('UserAgent')->default(null);
            $table->string('Platform')->default(null);
            $table->string('Browser')->default(null);
            $table->string('BrowserFullName')->default(null);
            $table->string('Device')->default(null);
            $table->string('Pointing')->default(null);
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
