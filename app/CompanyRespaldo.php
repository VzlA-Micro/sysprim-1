<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyRespaldo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table='company_respaldo';
    //
    protected $appends=['typeDocument', 'document', 'operator', 'numberPhone',];

    public function getOperatorAttribute(){
        return $this->operator=substr($this->phone,0,6);
    }

    public function getNumberPhoneAttribute(){
        return $this->phone=substr($this->phone,6,11);
    }

    public function getTypeDocumentAttribute(){
        return $this->typeDocument=substr($this->RIF,0,1);
    }

    public function getDocumentAttribute(){
        return $this->document=substr($this->RIF,1,11);
    }
}
