<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('digit',3)->nullable();
            $table->double('amount',11,2)->nullable();
            $table->string('status')->nullable();
            $table->string('bank',3)->nullable();
            $table->date('fiscal_period');
            $table->integer('company_id')->unsigned();
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
        Schema::dropIfExists('taxes');
    }
}
