<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',15)->unique();
            $table->text('name');
            $table->float('alicuota');
            $table->integer('min_tribu_men');
            $table->integer('group_ciu_id')->unsigned();
            $table->foreign('group_ciu_id')->references('id')->on('group_ciu');
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
        Schema::dropIfExists('ciu');
    }
}
