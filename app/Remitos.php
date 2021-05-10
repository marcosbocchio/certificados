<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remitos extends Model
{
    protected $table='remitos';

    public function frente_origen(){

        return $this->hasOne('App\Frentes','id','frente_origen_id');

    }

    public function frente_destino(){

        return $this->hasOne('App\Frentes','id','frente_destino_id');

    }

}
