<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    protected $table='equipos';

    public function metodoEnsayos(){

        return $this->belongsTo('App\MetodoEnsayos','metodo_ensayo_id','id');
        
    }

    // Todos los métodos del equipo (incluye el principal de metodo_ensayo_id)
    public function metodos(){

        return $this->belongsToMany('App\MetodoEnsayos','equipo_metodo_ensayo','equipo_id','metodo_ensayo_id');

    }

    public function tipoEquipamiento () {

        return $this->belongsTo('App\TipoEquipamiento','tipo_equipamiento_id','id');
    }

    public function scopeFiltro($query, $filtro='') {

        if (trim($filtro) != '') {
            
                $query->WhereRaw("equipos.codigo LIKE '%" . $filtro . "%'")    
                      ->orWhereRaw("equipos.descripcion LIKE '%" . $filtro . "%'")  
                      
                    ->orWhereHas('tipoEquipamiento', function ($q) use($filtro) {
                    $q->WhereRaw("tipos_equipamiento.codigo LIKE '%" . $filtro . "%'");
                    })                           

                    ->orWhereHas('metodos', function ($q) use($filtro) {
                        $q->WhereRaw("metodo_ensayos.metodo = '" .  $filtro ."'" );

                    });         
    
        }
        
    }
}
