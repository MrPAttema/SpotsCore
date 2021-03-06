<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTouristtaxesArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('touristtax_archives', function (Blueprint $table) {
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
      Schema::table('touristtax_archives', function (Blueprint $table) {
          $table->foreign('reservation_id')->references('id')->on('reservation_archives');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('touristtax_archives');
    }
}
