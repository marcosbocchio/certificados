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


   public function scopeFiltro($query, $filtro='') {

    if (trim($filtro) != '') {

        $query->WhereRaw("servicios.descripcion LIKE '%" . $filtro . "%'")
            ->orWhereRaw("servicios.abreviatura LIKE '%" . $filtro . "%'")
            ->orWhereHas('metodoEnsayos', function ($q) use($filtro) {
                $q->WhereRaw("metodo_ensayos.metodo LIKE '%" . $filtro . "%'");
            });

    }

}
}
