<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCiuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_ciu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ciu_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->foreign('ciu_id')->references('id')->on('ciu')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->string('status',10)->nullable();
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
        Schema::dropIfExists('company_ciu');
    }
}
