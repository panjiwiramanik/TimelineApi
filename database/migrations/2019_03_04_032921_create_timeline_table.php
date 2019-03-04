<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelineTable extends Migration
{

    public function up()
    {
        Schema::create('Timeline', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->datetime('date');
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('Timeline');
    }
}
