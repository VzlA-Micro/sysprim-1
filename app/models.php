<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class models extends Model
{
    protected $table= 'models';
    
    public function brand() {
        return $this->belongsTo('\App\brand', 'brand_id');
    }
}
