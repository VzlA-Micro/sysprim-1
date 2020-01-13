<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisingTypePublicityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_type_publicity', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('advertising_type_id')->unsigned();
            // $table->integer('publicity_id')->unsigned();
            // $table->foreign('advertising_type_id')->references('id')->on('advertising_type');
            // $table->foreign('publicity_id')->references('id')->on('publicity');
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
        Schema::dropIfExists('advertising_type_publicity');
    }
}
