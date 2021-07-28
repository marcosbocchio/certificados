<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallesPm extends Model
{
    protected $table='detalles_pm';

    public function referencia(){

        return $this->belongsTo('App\DetallesPmReferencias','detalle_pm_referencia_id','id');

    }
}
