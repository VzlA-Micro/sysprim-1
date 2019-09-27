<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiuTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciu_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->float('base');
            $table->float('deductions');
            $table->float('withholding');
            $table->float('fiscal_credits');

            $table->integer('taxes_id')->unsigned();
            $table->integer('ciu_id')->unsigned();
            $table->foreign('taxes_id')->references('id')->on('taxes');
            $table->foreign('ciu_id')->references('id')->on('ciu');

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
        Schema::dropIfExists('ciu_taxes');
    }
}
