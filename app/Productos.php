<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table="productos";

    public function unidadMedidas(){

        return $this->belongsTo('App\UnidadesMedidas','unidades_medida_id','id');
        
    }
}
