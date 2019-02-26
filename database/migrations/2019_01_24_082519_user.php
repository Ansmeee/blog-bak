<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigInteger('id')->autoIncrement();
            $table->string('name', 100);
            $table->string('icon', 100);
            $table->string('email', 200);
            $table->string('motto', 200);
            $table->string('hobby', 200);
            $table->bigInteger('type');
            $table->dateTime('ctime');
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
