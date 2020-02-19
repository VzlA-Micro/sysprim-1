<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelineTypeVehicle extends Migration
{

    public function up()
    {
        Schema::create('timeline_type_vehicle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_vehicle_id')->unsigned();
            $table->date('since')->default('2020-01-01');
            $table->date('to')->default('2020-12-31');
            $table->float('rate');
            $table->float('rate_UT');
            $table->foreign('type_vehicle_id')->references('id')->on('vehicle_type');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('timeline_type_vehicle');
    }
}
