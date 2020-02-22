<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Parish extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;
    protected $table="parish";
}
