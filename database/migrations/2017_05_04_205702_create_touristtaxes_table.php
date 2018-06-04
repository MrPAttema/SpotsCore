<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTouristtaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('touristtaxes', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('reservation_id')->unsigned();
          $table->smallInteger('tax_status');
          $table->string('tax_price');
          $table->integer('persons');
          $table->integer('za_zo');
          $table->integer('zo_ma');
          $table->integer('ma_di');
          $table->integer('di_wo');
          $table->integer('wo_do');
          $table->integer('do_vrij');
          $table->integer('vrij_za');
          $table->timestamps();
      });
      Schema::table('touristtaxes', function (Blueprint $table) {
          $table->foreign('reservation_id')->references('id')->on('reservations');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('touristtaxes');
    }
}
