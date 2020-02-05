<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProperty extends Model
{
    //
    protected $table='user_property';

    public function property() {
        return $this->belongsToMany('App\Property', 'property')
            ->withPivot('property_id');
    }
}
