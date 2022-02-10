<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformesTt extends Model
{
    protected $table='informes_tt';

    public function detalle(){

        return $this->hasMany('App\DetallesTt','informe_tt_id','id');

    }

}
