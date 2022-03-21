<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallesRg extends Model
{
    protected $table="detalles_rg";

    public function referencia(){

        return $this->belongsTo('App\DetallesRgReferencias','detalle_rg_referencia_id','id');

    }
}
