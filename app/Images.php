<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Images extends Model
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'images';
}
