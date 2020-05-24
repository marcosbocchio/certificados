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

    public function ot(){

        return $this->belongsTo('App\Ots','ot_id','id');
      
      }

    
    public function scopeFiltro($query, $filtro='') {

      if (trim($filtro) != '') {
          
            $query->WhereRaw("interno_equipos.nro_interno LIKE '%" . $filtro . "%'")

                ->orWhereHas('equipo', function ($q) use($filtro) {
                    $q->WhereRaw("equipos.codigo LIKE '%" . $filtro . "%'");
                })   
                
                ->orWhereHas('ot.cliente', function ($q) use($filtro) {
                  $q->WhereRaw("clientes.nombre_fantasia LIKE '%" . $filtro . "%'");
                }) 

                ->orWhereHas('ot.localidad', function ($q) use($filtro) {
                  $q->WhereRaw("localidades.localidad LIKE '%" . $filtro . "%'");
                }) 

                ->orWhereHas('equipo.metodoEnsayos', function ($q) use($filtro) {
                  $q->WhereRaw("metodo_ensayos.metodo = '" .  $filtro ."'" );
                }) 

                ->orWhereHas('ot', function ($q) use($filtro) {
                    $q->WhereRaw("ots.numero LIKE '%" . $filtro . "%'");
                });         
      
      }
    
  }
    
  
}
