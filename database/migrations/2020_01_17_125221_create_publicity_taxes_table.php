<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicityTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicity_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('taxe_id')->unsigned();
            $table->integer('publicity_id')->unsigned();
            $table->foreign('taxe_id')->references('id')->on('taxes');
            $table->foreign('publicity_id')->references('id')->on('publicity');
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
        Schema::dropIfExists('publicity_taxes');
    }
}
