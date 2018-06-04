<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->tinyInteger('admin')->default(0);
            $table->string('facebook_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('adress')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('birthday')->nullable();
            $table->integer('phone')->nullable();
            $table->string('email')->unique();
            $table->string('work_location')->nullable();
            $table->string('work_department')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
