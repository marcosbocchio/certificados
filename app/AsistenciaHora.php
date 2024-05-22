<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Frentes;

class AsistenciaHora extends Model
{
    protected $table = 'asistencia_horas';
    protected $fillable = ['frente_id', 'fecha'];

    public function frente()
    {
        return $this->belongsTo(Frentes::class, 'frente_id');
    }

    public function detalles()
    {
        return $this->hasMany(AsistenciaDetalle::class, 'asistencia_horas_id');
    }
}
