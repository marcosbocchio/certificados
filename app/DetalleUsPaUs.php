<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleUsPaUs extends Model
{
    protected $table='detalle_us_pa_us';


    public function referencia(){

        return $this->belongsTo('App\DetallesUsPaUsReferencias','detalle_us_pa_us_referencia_id','id');

    }
}
