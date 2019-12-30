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
            $table->string('unit',3);
            $table->integer('quantity')->unsigned();
            $table->float('width')->unsigned();
            $table->float('height')->unsigned();
            $table->string('image');
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
