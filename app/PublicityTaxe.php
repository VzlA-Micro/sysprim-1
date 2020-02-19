<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PublicityTaxe extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'publicity_taxes';
}
