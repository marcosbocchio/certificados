<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalibracionesUs extends Model
{
    protected $table = "calibraciones_us";

    public function Palpador(){

        return $this->hasOne('App\InternoEquipos','id','palpador_id');
    
      }
}
