<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternoFuentes extends Model
{
    protected $table='interno_fuentes';

    public function fuentes(){

        return $this->belongsTo('App\fuentes','fuente_id','id');
      
      }  
}
