<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtInternosEquipos extends Model
{
    protected $table='ot_internos_equipos';
    protected $fillable = ['ot_id','interno_equipo_id'];
}
