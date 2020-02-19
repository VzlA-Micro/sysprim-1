<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    protected $table="roles";

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
