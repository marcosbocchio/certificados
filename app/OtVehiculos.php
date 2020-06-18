<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtVehiculos extends Model
{
    protected $table="ot_vehiculos" ;
    protected $fillable = ['ot_id','vehiculo_id'];

}
