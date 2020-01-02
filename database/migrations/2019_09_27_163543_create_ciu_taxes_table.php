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
            $table->decimal('base',12,2);
            $table->decimal('deductions',12,2)->nullable();
            $table->decimal('withholding',12,2)->nullable();
            $table->decimal('fiscal_credits',12,2)->nullable();
            $table->decimal('tax_rate',12,2)->nullable();
            $table->decimal('mora',12,2)->nullable();
            $table->decimal('unid_tribu',12,2)->nullable();
            $table->decimal('base_anticipated',12,2)->nullable()->default(0);
            $table->decimal('interest',12,2)->nullable();
            $table->integer('taxe_id')->unsigned();
            $table->integer('ciu_id')->unsigned();
            $table->foreign('taxe_id')->references('id')->on('taxes')->onDelete('cascade')
                ->onUpdate('cascade');
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
