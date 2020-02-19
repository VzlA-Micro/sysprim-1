<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class GroupCiiu extends Model implements Auditable{
    use \OwenIt\Auditing\Auditable;
    protected $table='group_ciu';
    protected $fillable = ['code', 'name'];
}
