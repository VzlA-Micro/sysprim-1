<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_id')->unsigned();
            $table->integer('taxe_id')->unsigned();
            $table->string('status',15);
            $table->float('fiscal_credits',8,2)->nullable();;
            $table->float('recharge',8,2)->nullable();;
            $table->float('recharge_mora',8,2)->nullable();
            $table->float('base_imponible',8,2)->nullable();
            $table->float('discount',8,2)->nullable();
            $table->float('previous_debt',8,2)->nullable();
            $table->boolean('type_payments');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
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
        Schema::dropIfExists('vehicles_taxes');
    }
}
