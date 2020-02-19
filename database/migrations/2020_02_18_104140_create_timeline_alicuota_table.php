<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelineAlicuotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_alicuota', function (Blueprint $table) {
            $table->increments('id');
            $table->date('since');
            $table->date('to');
            $table->float('value',13,2);
            $table->integer('alicuota_inmueble_id')->unsigned();
            $table->foreign('alicuota_inmueble_id')->references('id')->on('alicuota_inmueble')->onDelete('cascade');
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
        Schema::dropIfExists('timeline_alicuota');
    }
}
