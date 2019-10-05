<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /*esta relacion este en veremos*/
    public function up()
    {
        Schema::create('payments_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payments_type',20);
            $table->string('code_ref',15);
            $table->string('bank',20);
            $table->float('amount');
            $table->string('status',40);
            $table->integer('taxe_id')->unsigned();
            $table->foreign('taxe_id')->references('id')->on('taxes');
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
        Schema::dropIfExists('payments_taxes');
    }
}
