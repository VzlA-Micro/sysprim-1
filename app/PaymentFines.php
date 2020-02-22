<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentFines extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;
    protected $table='payments_fines';
}
