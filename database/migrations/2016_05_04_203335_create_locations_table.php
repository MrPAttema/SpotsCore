<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('locations', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->string('location_name');
          $table->string('location_location');
          $table->text('location_discription');
          $table->string('location_price_high');
          $table->string('location_date_high');
          $table->string('location_price_low');
          $table->string('location_date_low');
          $table->string('location_entertime');
          $table->string('location_exittime');
          $table->smallInteger('location_wifi');
          $table->smallInteger('location_tv');
          $table->smallInteger('location_radio');
          $table->smallInteger('location_shower');
          $table->smallInteger('location_publictransport');
          $table->smallInteger('location_smoking');
          $table->smallInteger('location_pets');
          $table->smallInteger('location_fireplace');
          $table->smallInteger('location_beds');
          $table->smallInteger('location_bedrooms');
          $table->smallInteger('location_maxpersons');
          $table->smallInteger('location_family');
          $table->integer('location_tax');
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
        Schema::dropIfExists('locations');
    }
}
