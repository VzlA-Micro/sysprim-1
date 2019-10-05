<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
    protected $table="brands";
    
    public function models() {
        return $this->onToMany('App\models','brand_id');
    }
}
