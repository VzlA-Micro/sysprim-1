<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('license_plate',10);
            $table->string('color',20);
            $table->string('body_serial',30);
            $table->string('serial_engine',25);
            $table->string('image')->nullable();
            $table->string('year');
            $table->integer('type_vehicle_id')->unsigned();
            $table->integer('model_id')->unsigned()->nullable();
            $table->foreign('model_id')->references('id')->on('models');
            $table->foreign('type_vehicle_id')->references('id')->on('vehicle_type');
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
        Schema::dropIfExists('vehicles');
    }
}
