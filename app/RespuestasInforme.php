<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestasInforme extends Model
{
    protected $table = "respuestas_informe";
    protected $fillable = [
        'informe_id',
        'item_categoria_id',
        'respuesta',
    ];
}
