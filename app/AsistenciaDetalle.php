<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsistenciaDetalle extends Model
{
    protected $table = 'asistencia_detalle';
    protected $fillable = ['asistencia_horas_id','ayudante_sn', 'operador_id', 'entrada', 'salida', 'contratista_id', 'parte','observaciones'];

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

    // Relación con Contratistas
    public function contratista()
    {
        return $this->belongsTo(User::class, 'contratista_id');
    }
}