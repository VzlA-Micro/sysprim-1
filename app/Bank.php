<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class Bank extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;


    protected $table="reference_bank";
    //

    protected $fillable = ['ref', 'bank','created_at','update_at','amount','name_deposito','surname_deposito','cedula','date_transference'];

}
