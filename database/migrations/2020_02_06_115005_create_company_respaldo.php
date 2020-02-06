<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyRespaldo extends Migration
{
   
    public function down()
    {
        Schema::dropIfExists('company_respaldo');
    }
}
