<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsistenciaDetalle extends Model
{
    protected $table = 'asistencia_detalle';
    protected $fillable = [
        'asistencia_horas_id', 'ayudante_sn', 'operador_id', 
        'entrada', 'salida', 'contratista_id', 'parte', 'observaciones',
        'hora_extra_sn', 's_d_f_sn', 'no_pagar', 'tecnica_id'
    ];

    // Relación con AsistenciaHora
    public function asistenciaHora()
    {
        return $this->belongsTo(AsistenciaHora::class, 'asistencia_horas_id');
    }

    // Relación con User
    public function operador()
    {
        return $this->belongsTo(User::class, 'operador_id');
    }

    // Relación con Clientes
    public function contratista()
    {
        return $this->belongsTo(Clientes::class, 'contratista_id');
    }

    // Relación con MetodoEnsayos (cada asistencia tiene una técnica relacionada)
    public function metodoEnsayo()
    {
        return $this->belongsTo(MetodoEnsayos::class, 'tecnica_id');
    }
}