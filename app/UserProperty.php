<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserProperty extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table='user_property';

    public function property() {
        return $this->belongsToMany('App\Property', 'property')
            ->withPivot('property_id');
    }
}
