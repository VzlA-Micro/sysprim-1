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
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('type_payment',3)->nullable();
            $table->string('code_payment',3)->nullable();
            $table->string('digit',3)->nullable();
            $table->double('amount',11,2)->nullable();
            $table->date('fiscal_period');
            $table->integer('bank_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->foreign('bank_id')->references('id')->on('banks');
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
