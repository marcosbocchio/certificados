<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParteVehiculos extends Model
{
    protected $table ="parte_vehiculos";

    public function vehiculo()
   {
       return $this->belongsTo('App\Vehiculos','vehiculo_id','id');
   }
}
