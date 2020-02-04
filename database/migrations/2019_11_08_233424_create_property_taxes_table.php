<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id')->unsigned();

            $table->integer('taxe_id')->unsigned();
//            $table->string('status',15);
            $table->float('recharge',8,2)->nullable();;
            $table->float('base_imponible',10,2)->nullable();
            $table->float('alicuota',8,2)->nullable();
            $table->float('interest',8,2)->nullable();
            $table->foreign('property_id')->references('id')->on('property');
            $table->foreign('taxe_id')->references('id')->on('taxes');
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
        Schema::dropIfExists('property_taxes');
    }
}
