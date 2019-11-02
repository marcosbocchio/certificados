<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RemitoInternoEquipos extends Model
{
    protected $table = 'remito_interno_equipos';

    public function InternoEquipo(){

        return $this->belongsTo('App\InternoEquipos','interno_equipo_id','id');
        
      }
}
