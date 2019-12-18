<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformesImportados extends Model
{
    protected $table="informes_importados";

    public function metodoEnsayos(){

         return $this->belongsTo('App\MetodoEnsayos','metodo_ensayo_id','id');
    
    }

    public function ejecutorEnsayo(){

        return $this->belongsTo('App\User','ejecutor_ensayo_id','id');
   
   }
}
