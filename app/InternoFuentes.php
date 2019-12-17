<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternoFuentes extends Model
{
    protected $table='interno_fuentes';

    public function fuente(){

        return $this->belongsTo('App\Fuentes','fuente_id','id')->withDefault();
      
      }  
}
