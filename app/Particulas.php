<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Particulas extends Model
{
    protected $table='particulas';

    public function color(){

        return $this->belongsTo('App\ColorParticulas','color_particula_id','id');
          
      }

}
