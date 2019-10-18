<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_vehicle', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payments_type',20);
            $table->string('code_ref',15);
            $table->string('bank',20);
            $table->float('amount',11);
            $table->string('status',40);
            $table->date('fiscal_period');
            $table->integer('vehicle_id')->unsigned();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
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
        Schema::dropIfExists('payments_vehicle');
    }
}
