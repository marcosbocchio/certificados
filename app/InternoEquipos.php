<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternoEquipos extends Model
{
    protected $table='interno_equipos';

    public function equipo(){

        return $this->belongsTo('App\Equipos','equipo_id','id');
        
      }

   public function internoFuentes(){

      return $this->belongsTo('App\InternoFuentes','interno_fuente_id','id');
    
    }
    
  
}
