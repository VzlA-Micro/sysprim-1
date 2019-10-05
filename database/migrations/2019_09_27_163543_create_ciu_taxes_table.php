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
            $table->float('deductions')->nullable();
            $table->float('withholding')->nullable();
            $table->float('fiscal_credits')->nullable();
            $table->integer('taxe_id')->unsigned();
            $table->integer('ciu_id')->unsigned();
            $table->foreign('taxe_id')->references('id')->on('taxes');
            $table->foreign('ciu_id')->references('id')->on('ciu');
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
