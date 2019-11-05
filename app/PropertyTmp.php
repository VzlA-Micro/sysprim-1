<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyTmp extends Model
{
    protected $table="property_tmp";
    //

    protected $fillable = ['document', 'name','created_at','update_at','code_cadastral','direction'];

}
