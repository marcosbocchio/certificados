<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tramos extends Model
{
    protected $table='tramo_perfil';

    public function referencia(){

        return $this->belongsTo('App\DetallesRiReferencias','tramo_ri_referencia_id','id');

    }
}
