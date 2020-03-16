<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('type')->nullable();
            $table->string('digit',3)->nullable();
            $table->string('bank',3)->nullable();
            $table->string('bank_name',30)->nullable();
            $table->string('branch',20)->nullable();
            $table->double('amount',15,2)->nullable();
            $table->string('status')->nullable();
            $table->date('fiscal_period');
            $table->date('fiscal_period_end')->nullable();
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
        Schema::dropIfExists('taxes');
    }
}
