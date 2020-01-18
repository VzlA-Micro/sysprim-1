<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('unit',3)->nullable();
            $table->integer('quantity')->unsigned()->nullable();
            $table->float('width',2)->unsigned()->nullable();
            $table->float('height',2)->unsigned()->nullable();
            $table->integer('side')->unsigned()->nullable();
            $table->integer('floor')->unsigned()->nullable();
            $table->string('image')->nullable();
            $table->integer('advertising_type_id')->unsigned();
            $table->foreign('advertising_type_id')->references('id')->on('advertising_type');
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
        Schema::dropIfExists('publicity');
    }
}
