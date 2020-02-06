<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValCatConstInmuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('val_cat_const_inmu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('value_catas_const_id')->unsigned();
            $table->integer('property_id')->unsigned();
            $table->foreign('value_catas_const_id')->references('id')->on('value_catastral_construccion')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('property')->onDelete('cascade');
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
        Schema::dropIfExists('val_cat_const_inmu');
    }
}
