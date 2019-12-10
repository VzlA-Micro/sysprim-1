<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table="brands";
    
    public function models() {
        return $this->onToMany('App\Models','brand_id');
    }
}
