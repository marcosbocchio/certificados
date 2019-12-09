<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformesUsMe extends Model
{
    protected $table='informes_us_me';

    public function detalle_us_me(){

        return $this->hasMany('App\DetalleUsMe','informe_us_me_id','id');
        
        }
}
