<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{

    public function up()
    {
        Schema::create('User', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('email', 60);
            $table->string('username', 30);
            $table->string('password', 225);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('User');
    }
}
