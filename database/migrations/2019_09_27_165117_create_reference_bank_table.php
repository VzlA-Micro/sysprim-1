<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferenceBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reference_bank', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref',20);
            $table->string('bank',20);
            $table->float('amount',8);
            $table->string('name_deposito',30);
            $table->string('surname_deposito',30);
            $table->string('cedula',8);
            $table->date('date_transference');
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
        Schema::dropIfExists('reference_bank');
    }
}
