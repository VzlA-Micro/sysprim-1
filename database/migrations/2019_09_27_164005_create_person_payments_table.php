<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /*esta relacion este en veremos*/
    public function up()
    {
        Schema::create('person_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->string('ci',30);
            $table->string('number_deposit',10);
            $table->string('file',80)->nullable();
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
