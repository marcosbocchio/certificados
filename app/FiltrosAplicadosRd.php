<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FiltrosAplicadosRd extends Model
{
    protected $table = 'filtros_aplicados_rd';
    protected $fillable = ['descripcion'];
}
