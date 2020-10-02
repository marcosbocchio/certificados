<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    protected $table='informes';

    public function metodoEnsayos(){

        return $this->belongsTo('App\MetodoEnsayos','metodo_ensayo_id','id');

     }

     public function tecnica(){

        return $this->belongsTo('App\Tecnicas','tecnica_id','id');

     }


}
