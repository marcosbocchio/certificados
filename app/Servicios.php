<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
   protected  $table='servicios';

   public function unidadMedidas(){

      return $this->belongsTo('App\UnidadesMedidas','unidades_medida_id','id');
      
  }

  public function metodoEnsayos(){

   return $this->belongsTo('App\MetodoEnsayos','metodo_ensayo_id','id');
   
   }
}