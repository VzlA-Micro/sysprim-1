<?php

namespace App;
use App\Company;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FineCompany extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;
    
    protected $table='fines_company';
}
