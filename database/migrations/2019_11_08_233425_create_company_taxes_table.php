<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->integer('taxe_id')->unsigned();
            $table->decimal('deductions',12,2)->nullable();//Deduciones sede industiria
            $table->decimal('withholding',12,2)->nullable();//retenciones
            $table->decimal('fiscal_credits',12,2)->nullable();//credito fiscal
            $table->integer('day_mora')->default(0);//dia que lleva moroso
            $table->foreign('company_id')->references('id')->on('company');
            $table->foreign('taxe_id')->references('id')->on('taxes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_taxes');
    }
}
