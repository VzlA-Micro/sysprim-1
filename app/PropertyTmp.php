<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PropertyTmp extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table="property_tmp";
    //

    protected $fillable = ['document', 'name','created_at','update_at','code_cadastral','direction'];

}
