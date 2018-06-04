<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_archives', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->integer('res_status')->nullable();
            $table->integer('res_week1')->nullable();
            $table->integer('res_week2')->nullable();
            $table->integer('res_week3')->nullable();
            $table->integer('res_week4')->nullable();
            $table->timestamp('res_aanvraagtijd');
            $table->integer('res_toegewezen_week')->nullable();
            $table->boolean('res_akkoord')->nullable();
            $table->timestamp('res_akkoordtijd')->nullable();
            $table->timestamps();
        });
        Schema::table('reservation_archives', function (Blueprint $table) {
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_archives');
    }
}
