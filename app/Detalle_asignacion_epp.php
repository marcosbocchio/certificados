<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_asignacion_epp extends Model
{

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id', 'id');
    }

    protected $fillable = [
        'asignacion_epp_id',
        'producto_id',
        'cantidad'
    ];

    protected $table="detalle_asignacion_epp";
}
