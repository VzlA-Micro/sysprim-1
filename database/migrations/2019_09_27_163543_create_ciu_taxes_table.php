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
            $table->decimal('base',15,2);//base imponible
            $table->decimal('base_anticipated',15,2)->nullable()->default(0);//impuesto anticipado
            $table->decimal('recharge',15,2)->nullable();//Recargo
            $table->decimal('tax_unit',12,2)->nullable();//Valor de unidad tributaria
            $table->decimal('interest',12,2)->nullable();//intereset por numeros de dias
            $table->decimal('taxable_minimum',12,2)->nullable()->default(0);//Minimo tributable en caso de tener 0
            $table->integer('taxe_id')->unsigned();
            $table->integer('ciu_id')->unsigned();
            $table->foreign('taxe_id')->references('id')->on('taxes')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('ciu_id')->references('id')->on('ciu')->onDelete('cascade');
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
