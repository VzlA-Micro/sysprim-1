<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinesInmuebleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fines_inmueble', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inmueble_id')->unsigned();
            $table->integer('fine_id')->unsigned();
            $table->float('unid_tribu_value',12);
            $table->foreign('fine_id')->references('id')->on('fines');
            $table->foreign('inmueble_id')->references('id')->on('inmueble');
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
        Schema::dropIfExists('fines_company');
    }
}
