<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',40);
            $table->string('RIF',40);
            $table->string('code_catastral',20);
            $table->string('license',20);
            $table->date('opening_date');
            $table->string('lat',20);
            $table->string('lng',20);
            $table->string('address',20);
            $table->integer('number_employees')->nullable();
            $table->string('sector',100)->nullable();
            $table->string('image',255)->nullable();
            $table->integer('parish_id')->unsigned();
            $table->foreign('parish_id')->references('id')->on('parish');
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
        Schema::dropIfExists('company');
    }
}
