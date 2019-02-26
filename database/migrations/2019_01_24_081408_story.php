<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Story extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigInteger('id')->autoIncrement();
            $table->string('title', 200);
            $table->string('summay', 200);
            $table->mediumText('content');
            $table->string('banner', 200);
            $table->string('label', 200);
            $table->dateTime('date');
            $table->string('locaation', 100);
            $table->bigInteger('type');
            $table->bigInteger('like');
            $table->bigInteger('dislike');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
