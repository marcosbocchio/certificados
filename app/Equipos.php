<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    protected $table='equipos';

    public function metodoEnsayos(){

        return $this->belongsTo('App\MetodoEnsayos','metodo_ensayo_id','id');
        
        }
}
