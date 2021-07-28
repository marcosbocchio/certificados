<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallesLp extends Model
{
    protected $table="detalles_lp";

    public function referencia(){

        return $this->belongsTo('App\DetallesLpReferencias','detalle_lp_referencia_id','id');

    }
}
