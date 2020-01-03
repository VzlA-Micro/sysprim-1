<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    
    public function models() {
        return $this->onToMany('App\Models','brand_id');
    }
}
