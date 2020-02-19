<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserPublicity extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table='users_publicity';
}
