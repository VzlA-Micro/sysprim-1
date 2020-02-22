<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelineCiuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_ciu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('alicuota');
            $table->integer('min_tribu_men');
            $table->date('since')->default('2019-01-01');
            $table->date('to')->default('2020-12-31');
            $table->integer('ciu_id')->unsigned();
            $table->foreign('ciu_id')->references('id')->on('ciu')->onDelete('cascade');
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
        Schema::dropIfExists('timeline_ciu');
    }
}
