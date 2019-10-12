<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_fines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payments_type',20);
            $table->string('code_ref',15);
            $table->string('bank',20);
            $table->float('amount');
            $table->string('status',40);
            $table->integer('fine_company_id')->unsigned();
            $table->foreign('fine_company_id')->references('id')->on('fines_company');
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
        Schema::dropIfExists('payments_fines');
    }
}
