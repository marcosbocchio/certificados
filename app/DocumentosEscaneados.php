<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentosEscaneados extends Model
{
    protected $table = "documentos_escaneados";

    public function Usuario(){

        return $this->belongsTo('App\User','user_id','id');
   
   }
}
