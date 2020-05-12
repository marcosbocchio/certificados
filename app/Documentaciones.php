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

public function InternoFuente(){

    return $this->belongsToMany('App\InternoFuentes','App\InternoFuenteDocumentaciones','documentacion_id','interno_fuente_id');

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
                        }); 
                    });
                   

        }
        elseif (trim($tipo)) {
        
             $query->WhereRaw("documentaciones.tipo = '" .  $tipo ."'" ); 

        }
}

   
}
