<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table="reference_bank";
    //

    protected $fillable = ['ref', 'bank','created_at','update_at','amount','name_deposito','surname_deposito','cedula','date_transference'];

}
