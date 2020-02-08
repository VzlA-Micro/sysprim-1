<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parish_id')->unsigned();
            $table->integer('type_inmueble_id')->unsigned();
            $table->integer('value_cadastral_ground_id')->unsigned();
            $table->integer('value_cadastral_build_id')->unsigned();
            $table->string('code_cadastral',35)->unique();
            $table->string('address');
            $table->float('area_ground');
            $table->float('area_build');
            $table->string('lat',20);
            $table->string('lng',20);
            $table->foreign('parish_id')->references('id')->on('parish')->onDelete('cascade');
            $table->foreign('type_inmueble_id')->references('id')->on('alicuota_inmueble')->onDelete('cascade');
            $table->foreign('value_cadastral_ground_id')->references('id')->on('value_catastral_terreno')->onDelete('cascade');
            $table->foreign('value_cadastral_build_id')->references('id')->on('value_catastral_construccion')->onDelete('cascade');
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
        Schema::dropIfExists('property');
    }
}
