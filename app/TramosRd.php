<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TramosRd extends Model
{
    protected $table='tramo_perfil_rd';

    public function referencia(){

        return $this->belongsTo('App\DetallesRdReferencias','tramo_rd_referencia_id','id');

    }
}
