<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tributo extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;
    protected $table='unidad_tribu';
}
