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

   public function scopeFiltro($query, $filtro='') {

    if (trim($filtro) != '') {
       
          $query->WhereRaw("documentaciones.tipo LIKE '%" . $filtro . "%'")
                ->orWhereRaw("documentaciones.titulo LIKE '%" . $filtro . "%'")    
                ->orWhereRaw("documentaciones.descripcion LIKE '%" . $filtro . "%'") 
                ->orWhereHas('metodoEnsayo', function ($q) use($filtro) {
                    $q->WhereRaw("metodo_ensayos.metodo LIKE '%" . $filtro . "%'");
                });  
   
    }
 
}

   
}
