<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UsuarioDocumentaciones;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documentaciones extends Model
{
    // use SoftDeletes;

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

        $instance =  $this->belongsToMany('App\InternoEquipos','App\InternoEquipoDocumentaciones','documentacion_id','interno_equipo_id')->withPivot([
            'certificado_verificacion_sn',
        ]);
        return $instance;
    }

    public function internoFuente(){

        return $this->belongsToMany('App\InternoFuentes','App\InternoFuenteDocumentaciones','documentacion_id','interno_fuente_id');

    }

    public function vehiculo(){

        return $this->belongsToMany('App\Vehiculos','App\VehiculoDocumentaciones','documentacion_id','vehiculo_id');

    }

    public function TipoDocumentoUsuario()
    {
        return $this->belongsToMany('App\TiposDocumentosUsuarios','App\UsuarioDocumentaciones','documentacion_id','tipo_documentacion_usuario_id');
    }

    public function userInternoEquipo() {

        return $this->belongsToMany('App\User','App\InternoEquipoDocumentaciones','documentacion_id','interno_equipo_user_id');

     }

    public function scopeVencido($query,$vencido_sn){

        if($vencido_sn) {

           $query->WhereRaw("date(documentaciones.fecha_caducidad) < curdate()");

        }

    }


    public function scopeFiltro($query, $filtro='', $tipo='') {
        if (trim($filtro) && !trim($tipo)) {
            $query->whereRaw("documentaciones.titulo LIKE '%" . $filtro . "%'")
                ->orWhereRaw("documentaciones.descripcion LIKE '%" . $filtro . "%'")
    
                ->orWhereHas('metodoEnsayo', function ($q) use ($filtro) {
                    $q->WhereRaw("metodo_ensayos.metodo LIKE '%" . $filtro . "%'");
                })
                ->orWhereHas('usuario', function ($q) use ($filtro) {
                    $q->WhereRaw("users.name LIKE '%" . $filtro . "%'");
                })
                ->orWhereHas('userInternoEquipo', function ($q) use ($filtro) {
                    $q->WhereRaw("users.name LIKE '%" . $filtro . "%'");
                })
                ->orWhereHas('internoEquipo', function ($q) use ($filtro) {
                    $q->WhereRaw("interno_equipos.nro_interno LIKE '%" . $filtro . "%'");
                })
                ->orWhereHas('vehiculo', function ($q) use ($filtro) {
                    $q->WhereRaw("vehiculos.nro_interno LIKE '%" . $filtro . "%' AND vehiculos.habilitado_sn = 1");
                })
                ->orWhereHas('internoFuente', function ($q) use ($filtro) {
                    $q->WhereRaw("interno_fuentes.nro_serie LIKE '%" . $filtro . "%'");
                });
        } elseif (trim($filtro) && trim($tipo)) {
            $query->where("documentaciones.tipo", $tipo)
                ->where(function ($q) use ($filtro) {
                    $q->WhereRaw("documentaciones.titulo LIKE '%" . $filtro . "%'")
                        ->orWhereRaw("documentaciones.descripcion LIKE '%" . $filtro . "%'")
    
                        ->orWhereHas('metodoEnsayo', function ($q) use ($filtro) {
                            $q->WhereRaw("metodo_ensayos.metodo LIKE '%" . $filtro . "%'");
                        })
                        ->orWhereHas('usuario', function ($q) use ($filtro) {
                            $q->WhereRaw("users.name LIKE '%" . $filtro . "%'");
                        })
                        ->orWhereHas('userInternoEquipo', function ($q) use ($filtro) {
                            $q->WhereRaw("users.name LIKE '%" . $filtro . "%'");
                        })
                        ->orWhereHas('internoEquipo', function ($q) use ($filtro) {
                            $q->WhereRaw("interno_equipos.nro_interno LIKE '%" . $filtro . "%'");
                        })
                        ->orWhereHas('vehiculo', function ($q) use ($filtro) {
                            $q->WhereRaw("vehiculos.nro_interno LIKE '%" . $filtro . "%' AND vehiculos.habilitado_sn = 1");
                        })
                        ->orWhereHas('internoFuente', function ($q) use ($filtro) {
                            $q->WhereRaw("interno_fuentes.nro_serie LIKE '%" . $filtro . "%'");
                        });
                });
        } elseif (trim($tipo)) {
            $query->WhereRaw("documentaciones.tipo = '" . $tipo . "'")
                ->WhereDoesntHave('vehiculo', function ($q) {
                    $q->WhereRaw("vehiculos.habilitado_sn = 0");
                });
        } else {
            $query->WhereDoesntHave('vehiculo', function ($q) {
                $q->WhereRaw("vehiculos.habilitado_sn = 0");
            });
        }
    
        return $query;
    }
    


}
