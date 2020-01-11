<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /*esta relacion este en veremos*/
    public function up()
    {

        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',15)->unique()->nullable();
            $table->string('digit',3)->nullable();
            $table->string('ref',10)->nullable();
            $table->string('lot',10)->nullable();
            $table->string('bank',10)->nullable();
            $table->string('status',20)->nullable();
            $table->double('amount',11,2);
            $table->string('type_payment',40)->nullable();
            $table->string('name',50)->nullable();
            $table->string('phone',15)->nullable();
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
        Schema::dropIfExists('payments');
    }
}
