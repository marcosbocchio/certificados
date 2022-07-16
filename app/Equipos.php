<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    protected $table='equipos';

    public function metodoEnsayos(){

        return $this->belongsTo('App\MetodoEnsayos','metodo_ensayo_id','id');
        
    }

    public function tipoEquipamiento () {

        return $this->belongsTo('App\TipoEquipamiento','tipo_equipamiento_id','id');
    }

    public function scopeFiltro($query, $filtro='') {

        if (trim($filtro) != '') {
            
                $query->WhereRaw("equipos.codigo LIKE '%" . $filtro . "%'")    
                      ->orWhereRaw("equipos.descripcion LIKE '%" . $filtro . "%'")   

                ->orWhereHas('metodoEnsayos', function ($q) use($filtro) {
                       $q->WhereRaw("metodo_ensayos.metodo = '" .  $filtro ."'" );

                    });         
        
        }
        
    }
}
