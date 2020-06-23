<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrazabilidadFuente extends Model
{
    protected $table='trazabilidad_fuente';    

    public function internoFuente(){

        return $this->belongsTo('App\InternoFuentes','interno_fuente_id','id');
      
      }
}
