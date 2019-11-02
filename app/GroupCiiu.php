<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupCiiu extends Model{
    protected $table='group_ciu';
    protected $fillable = ['code', 'name'];
}
