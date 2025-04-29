<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialUs extends Model
{
    protected $table = 'material_us';
    protected $fillable = [
        'componente_us_me_id',
        'descripcion',
        'grado',
        'espesor_nominal',
        'espesor_minimo_medido'
      ];
}
