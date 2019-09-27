<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyPublicityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_publicity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publicity_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->foreign('publicity_id')->references('id')->on('publicity');
            $table->foreign('company_id')->references('id')->on('company');
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
        Schema::dropIfExists('company_publicity');
    }
}
