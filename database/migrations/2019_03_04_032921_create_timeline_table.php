<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelineTable extends Migration
{

    public function up()
    {
        Schema::create('timeline', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->string('color');
            $table->string('date');
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('timeline');
    }
}
