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
            $table->integer('sector_nueva_nomenclatura')->nullable();
            $table->integer('sector_catastral');
            $table->text('name');
            $table->string('status',15);
            /*$table->integer('value_terreno_construccion');
            $table->integer('value_terreno_vacio');*/
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
        Schema::dropIfExists('value_catastral_terreno');
    }
}
