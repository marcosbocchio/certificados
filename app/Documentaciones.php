<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UsuarioDocumentaciones;

class Documentaciones extends Model
{
    protected $table= 'documentaciones';

    public function metodoEnsayo(){

      return $this->belongsTo('App\MetodoEnsayos','metodo_ensayo_id','id')->withDefault([
        'id' => '0',
    ]);

    }

    public function usuario(){

         return $this->belongsToMany('App\User','App\UsuarioDocumentaciones','documentacion_id');

    }

    public function internoEquipo(){

        return $this->belongsToMany('App\InternoEquipos','App\InternoEquipoDocumentaciones','documentacion_id','interno_equipo_id');

    }

    public function internoFuente(){

        return $this->belongsToMany('App\InternoFuentes','App\InternoFuenteDocumentaciones','documentacion_id','interno_fuente_id');

    }

    public function vehiculo(){

        return $this->belongsToMany('App\Vehiculos','App\VehiculoDocumentaciones','documentacion_id','vehiculo_id');

    }

    public function scopeVencido($query,$vencido_sn){

        if($vencido_sn) {

           $query->WhereRaw("date(documentaciones.fecha_caducidad) < curdate()");

        }

    }

   public function scopeFiltro($query, $filtro='',$tipo='') {

        if (trim($filtro)  && !trim($tipo)) {

            $query->WhereRaw("documentaciones.titulo LIKE '%" . $filtro . "%'")
                ->orWhereRaw("documentaciones.descripcion LIKE '%" . $filtro . "%'")
                ->orWhereHas('metodoEnsayo', function ($q) use($filtro) {
                    $q->WhereRaw("metodo_ensayos.metodo LIKE '%" . $filtro . "%'");
                })
                ->orWhereHas('usuario', function ($q) use($filtro) {
                    $q->WhereRaw("users.name LIKE '%" . $filtro . "%'");
                })
                ->orWhereHas('internoEquipo', function ($q) use($filtro) {
                    $q->WhereRaw("interno_equipos.nro_interno LIKE '%" . $filtro . "%'");
                })
                ->orWhereHas('vehiculo', function ($q) use($filtro) {
                    $q->WhereRaw("vehiculos.nro_interno LIKE '%" . $filtro . "%'");
                })
                ->orWhereHas('internoFuente', function ($q) use($filtro) {
                    $q->WhereRaw("interno_fuentes.nro_serie LIKE '%" . $filtro . "%'");
                });

        }elseif(trim($filtro) && trim($tipo)){

            $query ->where("documentaciones.tipo",$tipo)
                   ->where(function($q) use($filtro) {

                        $q->WhereRaw("documentaciones.titulo LIKE '%" . $filtro . "%'")
                            ->orWhereRaw("documentaciones.descripcion LIKE '%" . $filtro . "%'")

                        ->orWhereHas('metodoEnsayo', function ($q) use($filtro) {
                            $q->WhereRaw("metodo_ensayos.metodo LIKE '%" . $filtro . "%'");
                        })
                        ->orWhereHas('usuario', function ($q) use($filtro) {
                            $q->WhereRaw("users.name LIKE '%" . $filtro . "%'");
                        })
                        ->orWhereHas('internoEquipo', function ($q) use($filtro) {
                            $q->WhereRaw("interno_equipos.nro_interno LIKE '%" . $filtro . "%'");
                        })
                        ->orWhereHas('vehiculo', function ($q) use($filtro) {
                            $q->WhereRaw("vehiculos.nro_interno LIKE '%" . $filtro . "%'");
                        })
                        ->orWhereHas('internoFuente', function ($q) use($filtro) {
                            $q->WhereRaw("interno_fuentes.nro_serie LIKE '%" . $filtro . "%'");
                        });
                    });


        }
        elseif (trim($tipo)) {

             $query->WhereRaw("documentaciones.tipo = '" .  $tipo ."'" );

        }
}


}
