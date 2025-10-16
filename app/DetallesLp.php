<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallesLp extends Model
{
    protected $table = "detalles_lp";

    public function referencia()
    {
        return $this->belongsTo('App\DetallesLpReferencias', 'detalle_lp_referencia_id', 'id');
    }

    public function soldador1()
    {
        return $this->belongsTo('App\Soldadores', 'soldador1_id', 'id');
    }

    public function soldador2()
    {
        return $this->belongsTo('App\Soldadores', 'soldador2_id', 'id');
    }
}
