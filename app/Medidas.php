<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medidas extends Model
{
    protected $table = "medidas";

    public function unidadMedidas(){

        return $this->belongsTo('App\UnidadesMedidas','unidades_medida_id','id');
        
    }
}
