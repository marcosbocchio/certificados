<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternoEquipos extends Model
{
    protected $table='interno_equipos';
    protected $fillable = [
      'nro_serie', 'nro_interno', 'foco', 'voltaje', 'amperaje', 
      'probeta', 'dureza_calibracion', 'activo_sn', 'equipo_id', 
      'interno_fuente_id', 'frente_id', 'fecha_anul'
  ];
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

    public function scopeFiltro($query, $filtro = '', $activo_sn = null) {
      if (trim($filtro) != '') {
          $query->where(function ($q) use ($filtro) {
              $q->whereRaw("interno_equipos.nro_interno LIKE ?", ["%{$filtro}%"])
                ->orWhereHas('equipo', function ($q) use ($filtro) {
                    $q->whereRaw("equipos.codigo LIKE ?", ["%{$filtro}%"]);
                })
                ->orWhereHas('equipo.metodoEnsayos', function ($q) use ($filtro) {
                    $q->whereRaw("metodo_ensayos.metodo = ?", [$filtro]);
                })
                ->orWhereHas('equipo.tipoEquipamiento', function ($q) use ($filtro) {
                    $q->whereRaw("tipos_equipamiento.codigo LIKE ?", ["%{$filtro}%"]);
                })
                ->orWhereHas('frente', function ($q) use ($filtro) {
                    $q->whereRaw("frentes.codigo LIKE ?", ["%{$filtro}%"]);
                });
          });
      }
  
      // Si se envió el filtro de activos (y no es nulo), aplicarlo
      if (!is_null($activo_sn)) {
          $query->where('activo_sn', $activo_sn);
      }
  }

}
