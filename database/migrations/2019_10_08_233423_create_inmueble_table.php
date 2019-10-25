<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInmuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inmueble', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('value_catastral_construct_id')->unsigned();
            $table->integer('value_catastral_terreno_id')->unsigned();
            $table->integer('codigo_catastral');
            $table->string('direccion');
            $table->float('area');
            $table->float('value_terreno_construccion');
            $table->float('value_terreno_vacio');
            $table->foreign('value_catastral_terreno_id')->references('id')->on('value_catastral_terreno');
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
