<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParteManualDetalle extends Model
{
    protected $table = 'parte_manual_detalle';

    protected $fillable = [
        'parte_manual_id', 'planta_1', 'planta_2', 'tecnica', 'cantidad', 
        'equipo', 'operador1', 'operador2', 'horario', 
        'informe_id', 'informe_nro','inspector_id_1','inspector_id_2'
    ];

    public function parteManual()
    {
        return $this->belongsTo(ParteManual::class, 'parte_manual_id');
    }
}
