<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleObservacionRemito extends Model
{
    protected $table = 'detalle_observaciones_remitos';
    
    protected $fillable = [
        'remito_id', 
        'observaciones', 
        'cantidad'
    ];

    public function remito()
    {
        return $this->belongsTo(\App\Models\Remito::class, 'remito_id');
    }
}