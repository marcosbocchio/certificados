<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallesDz extends Model
{
    protected $table="detalles_dz";

    public function referencia(){

        return $this->belongsTo('App\DetallesDzReferencias','detalle_dz_referencia_id','id');

    }
}
