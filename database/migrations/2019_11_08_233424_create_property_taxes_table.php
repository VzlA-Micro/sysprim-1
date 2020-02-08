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
            $table->string('status',15);
            $table->float('recharge',13,2)->nullable();;
            $table->float('base_imponible',13,2)->nullable();
            $table->float('alicuota',13,2)->nullable();
            $table->float('interest',13,2)->nullable();
            $table->float('discount',13,2)->nullable();
            $table->float('fiscal_credit',13,2)->nullable();
            $table->foreign('property_id')->references('id')->on('property')->onDelete('cascade');
            $table->foreign('taxe_id')->references('id')->on('taxes')->onDelete('cascade');
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
