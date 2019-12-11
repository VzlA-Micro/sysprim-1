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
            $table->string('name',100);
            $table->string('RIF',40);
            $table->string('code_catastral',20);
            $table->string('license',20);
            $table->date('opening_date')->nullable();
            $table->string('lat',20)->nullable();
            $table->string('lng',20)->nullable();
            $table->text('address');
            $table->integer('number_employees')->nullable();
            $table->string('sector',100)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('image',255)->nullable();
            $table->integer('parish_id')->unsigned();
            $table->string('status',10)->nullable();
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
