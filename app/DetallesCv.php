<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallesCv extends Model
{
    protected $table="detalles_cv";

    public function referencia(){

        return $this->belongsTo('App\DetallesCvReferencias','detalle_cv_referencia_id','id');

    }
}
