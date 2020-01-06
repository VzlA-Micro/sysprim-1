<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('value_rate',11,3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bank_rates');
    }
}
