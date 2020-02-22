<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PropertyTaxes extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table="property_taxes";
}
