<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternoEquipos extends Model
{
    protected $table='interno_equipos';

    public function equipo(){

        return $this->belongsTo('App\Equipos','equipo_id','id');

      }

    public function internoFuente(){

        return $this->belongsTo('App\InternoFuentes','interno_fuente_id','id');

    }

    public function UserDosimetro(){

      return $this->belongsTo('App\Users','user_dosimetro_id','id');

  }    


    public function frente() {

        return $this->belongsTo('App\Frentes','frente_id','id');
    }

    public function scopeFiltro($query, $filtro='') {

      if (trim($filtro) != '') {

            $query->WhereRaw("interno_equipos.nro_interno LIKE '%" . $filtro . "%'")

                ->orWhereHas('equipo', function ($q) use($filtro) {
                    $q->WhereRaw("equipos.codigo LIKE '%" . $filtro . "%'");
                })

                ->orWhereHas('equipo.metodoEnsayos', function ($q) use($filtro) {
                  $q->WhereRaw("metodo_ensayos.metodo = '" .  $filtro ."'" );
                })

                ->orWhereHas('frente', function ($q) use($filtro) {
                    $q->WhereRaw("frentes.codigo  LIKE '%" . $filtro . "%'");
                  });
      }

  }


}
