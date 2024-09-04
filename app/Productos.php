<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table="productos";


    public function scopeFiltro($query, $filtro = '', $stockeable = null, $relacionado = null)
    {
        if (trim($filtro) != '') {
            $query->where(function ($q) use ($filtro) {
                $q->where('codigo', 'LIKE', "%{$filtro}%")
                  ->orWhere('descripcion', 'LIKE', "%{$filtro}%");
            });
        }
    
        if ($stockeable !== null) {
            $query->where('stockeable_sn', $stockeable);
        }
    
        if ($relacionado !== null) {
            $query->where('relacionado_a_placas_sn', $relacionado);
        }
    
        return $query;
    }

    public function unidadMedidas() {
        return $this->belongsTo('App\UnidadesMedidas', 'unidades_medida_id', 'id');
    }
}
