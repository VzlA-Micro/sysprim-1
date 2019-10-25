<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserValueCatasConstructInmuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('value_Catas_construct_inmueble', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('value_catastral_construccion_id')->unsigned();
            $table->integer('inmueble_id')->unsigned();
            $table->foreign('value_catastral_construccion_id')->references('id')->on('Value_catastral_construccion');
            $table->foreign('inmueble_id')->references('id')->on('inmueble');
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
        Schema::dropIfExists('extras');
    }
}
