<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frentes extends Model
{
   protected $table="frentes";
   protected $fillable = ['codigo', 'descripcion', 'horas_diarias_laborables', 'centro_distribucion_sn', 'controla_hs_extras_sn'];
}
