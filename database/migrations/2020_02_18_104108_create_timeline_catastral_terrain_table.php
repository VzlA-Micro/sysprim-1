<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelineCatastralTerrainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_catastral_terrain', function (Blueprint $table) {
            $table->increments('id');
            $table->date('since');
            $table->date('to');
            $table->float('value_built_terrain',13,2);
            $table->float('value_empty_terrain',13,2);
            $table->integer('value_catastral_terreno_id')->unsigned();
            $table->foreign('value_catastral_terreno_id')->references('id')->on('value_catastral_terreno')->onDelete('cascade');
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
        Schema::dropIfExists('timeline_catastral_terrain');
    }
}
