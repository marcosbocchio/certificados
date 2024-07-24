<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParteDetalles extends Model
{
    protected $table = 'parte_detalles';

    public function unidadMedidas(){

        return $this->belongsTo('App\UnidadesMedidas','unidades_medida_id','id');
        
    }
    
    public function parte()
    {
        return $this->belongsTo(Partes::class, 'parte_id', 'id');
    }

}
