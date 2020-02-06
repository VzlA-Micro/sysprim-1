<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates_taxes', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('rate_id')->unsigned();
            $table->integer('user_id')->unsigned();


            $table->integer('company_id')->nullable()->unsigned();
            $table->integer('person_id')->nullable()->unsigned();




            $table->integer('taxe_id')->unsigned();
            $table->double('tax_unit',11,2);
            $table->integer('cant_tax_unit');



            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('rate_id')->references('id')->on('rates')->onDelete('cascade');
            $table->foreign('taxe_id')->references('id')->on('taxes')->onDelete('cascade');

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
        Schema::dropIfExists('rates_taxes');
    }
}
