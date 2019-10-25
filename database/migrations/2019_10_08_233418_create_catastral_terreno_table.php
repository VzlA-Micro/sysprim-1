<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatastralTerrenoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('value_catastral_terreno', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parish_id')->unsigned();
            $table->integer('sector_nueva_nomenclatura');
            $table->integer('sector_catastral');
            $table->string('name',50);
            $table->float('value_terreno_construccion');
            $table->float('value_terreno_vacio');
            $table->foreign('parish_id')->references('id')->on('parish');
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
