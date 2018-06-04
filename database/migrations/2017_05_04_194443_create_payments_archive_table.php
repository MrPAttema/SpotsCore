<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsArchiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('payment_archives', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->integer('reservation_id')->unsigned();
          $table->smallInteger('payment_status');
          $table->timestamp('payment_time')->nullable();
          $table->integer('payment_price');
          $table->integer('payment_tax');
          $table->timestamps();
      });
      Schema::table('payment_archives', function (Blueprint $table) {
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
        Schema::dropIfExists('payment_archives');
    }
}
